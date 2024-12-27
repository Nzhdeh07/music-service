import requests

# URL вашего локального FastAPI приложения
base_url = "http://127.0.0.1:8080"


def test_read_root():
    response = requests.get(f"{base_url}/")
    assert response.status_code == 200
    assert response.json() == {"message": "Добро пожаловать на наш музыкальный сервис!",
                               "features": ["Запись и загрузка аудиофайлов",
                                            "Распознавание аккордов в реальном времени"], "endpoints": {
            "POST /upload-audio/": {
                "description": "Принимает URL аудиофайла, скачивает файл, обрабатывает его и возвращает распознанные аккорды.",
                "request": {"url": "URL аудиофайла"}, "response": {"chords": [
                    {"start_time": "Начало аккорда", "end_time": "Конец аккорда", "chord": "Название аккорда"}]}}}}


def test_upload_audio_success():
    # Тест на успешную загрузку и обработку аудио
    audio_url = "http://mutnyut.by/wp-content/uploads/2024/12/audio_recording-111.wav"
    response = requests.post(
        f"{base_url}/upload-audio/",
        data={"url": audio_url}
    )

    assert response.status_code == 200
    json_response = response.json()
    assert "chords" in json_response
    assert isinstance(json_response["chords"], list)
    assert len(json_response["chords"]) > 0


def test_upload_audio_invalid_url():
    # Тест на неправильный URL
    invalid_url = "http://invalid-url.com/audio_file.mp3"
    try:
        response = requests.post(
            f"{base_url}/upload-audio/",
            data={"url": invalid_url}
        )
    except RequestException as e:
        response = e.response

    assert response.status_code == 400
    json_response = response.json()
    assert "error" in json_response
    assert "Invalid URL" in json_response["error"]  # Убедитесь, что ошибка подходит


def test_empty_audio_url():
    # Тест на случай, если не передан URL
    try:
        response = requests.post(
            f"{base_url}/upload-audio/",
            data={"url": ""}
        )
    except RequestException as e:
        response = e.response

    assert response.status_code == 400
    json_response = response.json()
    assert "error" in json_response
    assert "Invalid URL: Invalid URL '': No scheme supplied. Perhaps you meant https://" in json_response[
        "error"]  # Убедитесь, что ошибка подходит
