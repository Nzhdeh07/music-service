import numpy as np
from fastapi import FastAPI, Form
from fastapi.responses import JSONResponse
from fastapi import BackgroundTasks
import os
import requests


np.int = np.int64  # Переопределяем np.int как np.int64

import numpy as np

np.float = np.float64  # Переопределяем np.float как np.float64

from fastapi import FastAPI, File, UploadFile
from fastapi.responses import JSONResponse
from fastapi.middleware.cors import CORSMiddleware
import os
import hashlib
import madmom

app = FastAPI()

# Настройка CORS
origins = [
    "https://busy-birds-punch.loca.lt",
    "http://localhost:8080",
    "https://mutnyut.by",
    "https://www.mutnyut.by",
]

app.add_middleware(
    CORSMiddleware,
    allow_origins=origins,  # Список разрешенных доменов
    allow_credentials=True,
    allow_methods=["*"],  # Разрешить все методы
    allow_headers=["*"],  # Разрешить все заголовки
)


def download_file(url, filename):
    headers = {
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36"
    }
    response = requests.get(url, headers=headers)  # Указываем заголовки
    response.raise_for_status()  # Проверяем ошибки
    with open(filename, "wb") as file:
        file.write(response.content)



@app.get("/")
def read_root():
    return {"message": "Hello, World!"}


# Функция для распознавания аккордов
def recognize_chords(audio_path):
    cache_dir = "cache/chord/"
    os.makedirs(cache_dir, exist_ok=True)
    hash_object = hashlib.md5(audio_path.encode())
    hashed_filename = hash_object.hexdigest() + ".txt"
    cache_file = os.path.join(cache_dir, hashed_filename)

    if os.path.exists(cache_file):
        with open(cache_file, "r") as f:
            cached_chords = [
                (float(start), float(end), label)
                for line in f
                for start, end, label in [line.strip().split(",")]
            ]
        return cached_chords

    feat_processor = madmom.features.chords.CNNChordFeatureProcessor()
    recog_processor = madmom.features.chords.CRFChordRecognitionProcessor()
    feats = feat_processor(audio_path)
    chords = recog_processor(feats)
    formatted_chords = []
    with open(cache_file, "w") as f:
        for chord in chords:
            start_time, end_time, chord_label = chord
            if ":maj" in chord_label:
                chord_label = chord_label.replace(":maj", "")
            elif ":min" in chord_label:
                chord_label = chord_label.replace(":min", "m")
            formatted_chords.append((start_time, end_time, chord_label))
            f.write(f"{start_time},{end_time},{chord_label}\n")

    return formatted_chords



@app.post("/upload-audio/")
async def upload_audio(url: str = Form(...)):  # Ожидаем данные из FormData
    print("url: ", url)
    # Путь к сохраненному файлу
    filename = "audio_file.mp3"

    # Скачиваем файл по URL
    try:
        download_file(url, filename)
    except Exception as e:
        return JSONResponse(status_code=400, content={"error": str(e)})

    # Анализируем аккорды
    chords = recognize_chords(filename)

    # Возвращаем JSON с аккордами
    response_data = [
        {"start_time": start, "end_time": end, "chord": chord}
        for start, end, chord in chords
    ]
    return JSONResponse(content={"chords": response_data})



if __name__ == "__main__":
    # Для локальной отладки, если необходимо
    import uvicorn

    uvicorn.run(app, host="0.0.0.0", port=8080)
