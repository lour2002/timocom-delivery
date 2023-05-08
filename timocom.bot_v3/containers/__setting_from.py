import time
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.by import By


def setting_from(self, data):

    from_country = data['as_country']
    zip = data['as_zip']
    radius = data['as_radius']

    # Перезагрузить страницу (после поиска не смог найти нормальный селектор на закрытие окна перевозки)
    # self.driver.get("https://my.timocom.com/app/tccargo/freights/search/")
    # time.sleep(5)
    # Сбрасываем настройки фильтра
    self.driver.find_element(By.XPATH, "//button[@data-testid='SearchFiler/reset']").click()
    # Ожидаем 5 сек, для того, что бы произошла очистка полей. Если убрать, она очистит часть заполненного из-за позднего отрабатывания
    time.sleep(5)
    # FROM
    # Выбираем Area search
    self.driver.find_element(By.CSS_SELECTOR,
                             '[data-testid="LoadingPlacesFilter/startPlaceFilterOption-area-input"]').click()
    # Нажимаем на список стран
    self.driver.find_element(By.CSS_SELECTOR, "#fromGeoFilter\\.countryId").click()
    # Выбираем страну
    self.driver.find_element(By.XPATH, f"//div[contains(text(), '{from_country}')]").click()
    # Указываем город
    self.driver.find_element(By.ID, "fromGeoFilter.geoAutocompleteData").send_keys(f"{zip}")
    time.sleep(3)
    # Указываем радиус
    # При попытке напрямую ввести значения или очистить поле, старое знаечение остается. По этому использовал Keys.CONTROL,'a' и Keys.DELETE
    self.driver.find_element(By.NAME, "fromGeoFilter.radius").send_keys(Keys.CONTROL, 'a')
    self.driver.find_element(By.NAME, "fromGeoFilter.radius").send_keys(Keys.DELETE)
    self.driver.find_element(By.NAME, "fromGeoFilter.radius").send_keys(f"{radius}")
    print("Поля from заполнены")
