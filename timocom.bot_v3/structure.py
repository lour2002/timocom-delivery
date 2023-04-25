import time
from containers.__set_auth import set_auth
from containers.__close_popups import close_windows
from containers.__setting_from import setting_from
from containers.__setting_to import setting_to
from containers.__setting_requirements import setting_requirements
from containers.__setting_date import setting_date
from containers.__search import search

# Создание класса тестов для авторизации пользователя
class TestAuth():

    # Инициализация драйвера
    def __init__(self, driver):
        self.driver = driver

    # Функция, которая будет запускаться единожды для авторизации и закрытия всех попапов
    def setup_method(self):
        set_auth(self)  # Функция авторизации пользователя
        close_windows(self)  # Функция закрытия окон браузера

    # Основная часть теста
    def test_run(self, data, url):
        print(data)
        setting_from(self, data)  # Функция заполнения поля "Откуда"
        time.sleep(5)
        setting_to(self, data)  # Функция заполнения поля "Куда"
        time.sleep(5)
        setting_requirements(self, data)  # Функция выбора параметров
        time.sleep(5)
        setting_date(self, data)  # Функция выбора даты
        time.sleep(5)
        search(self, data, url) # Функция поиска
