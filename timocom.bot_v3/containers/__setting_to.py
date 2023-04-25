import time
from selenium.webdriver.common.by import By

def setting_to(self, data):
    #Формируем удобные списки, что бы легче было назначать
    to_country = []
    zip_code = []

    # Получаем страны и zip-коды
    for option in data['toSelectOptArray']:
        to_country.append(option['as_country_to'])
        zip_code.append([option['post1'], option['post2'], option['post3']])


    # TO
    # Нажимаем на Country selection
    self.driver.find_element(By.CSS_SELECTOR, '[data-testid="LoadingPlacesFilter/destinationPlaceFilterOption-country-input"]').click()

    # Цикл для добавления нужного количества кнопок
    for i in range(len(to_country)-1):
        #Не нашел селектор адекватный для кнопки (+)
        self.driver.find_element(By.CSS_SELECTOR, 'div:nth-child(3) > fieldset button').click()
    # Заполняем таблицу
    for i in range(len(to_country)):
        # Нажимаем на список стран
        self.driver.find_element(By.ID, f"toZipFilter-country-{i}").click()
        # Выбираем страну
        self.driver.find_element(By.XPATH, f"//div[contains(text(), '{to_country[i]}')]").click()
        # Указываем zip коды
        self.driver.find_element(By.ID, f"toZipFilter-zip1-{i}").send_keys(f"{zip_code[i][0]}")
        self.driver.find_element(By.ID, f"toZipFilter-zip2-{i}").send_keys(f"{zip_code[i][1]}")
        self.driver.find_element(By.ID, f"toZipFilter-zip3-{i}").send_keys(f"{zip_code[i][2]}")
    print("Поля to заполнены")