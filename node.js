const express = require('express');
const multer = require('multer');
const path = require('path');
const fs = require('fs');

const app = express();
const PORT = 3000;

// Настройка Multer для загрузки файлов
const upload = multer({ dest: 'uploads/' });

// Маршрут для загрузки аудио
app.post('/upload-audio', upload.single('audio'), async (req, res) => {
    try {
        const filePath = req.file.path;

        // TODO: Передать файл в скрипт для анализа (пример ниже)
        const chords = [
            [0, 10, "C:maj"],
            [10, 20, "G:maj"],
            [20, 30, "Am"]
        ];

        // Удалить временный файл после обработки
        fs.unlink(filePath, (err) => {
            if (err) console.error('Ошибка удаления файла:', err);
        });

        res.json({ chords });
    } catch (error) {
        console.error('Ошибка обработки файла:', error);
        res.status(500).json({ error: 'Ошибка обработки файла.' });
    }
});

// Запуск сервера
app.listen(PORT, () => console.log(`Сервер запущен на http://localhost:${PORT}`));
