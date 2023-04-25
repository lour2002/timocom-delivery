import time
from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions
from selenium.webdriver.support.wait import WebDriverWait


def set_auth(self):
    #Переходим на указанный url
    self.driver.get("https://my.timocom.com/app/tco/freight/search/")
    #жидаем до 3 сек появления эллемента и атрибутом name=email
    self.driver.maximize_window()
    WebDriverWait(self.driver, 3).until(
        expected_conditions.presence_of_element_located((By.NAME, "email")))
    self.driver.find_element(By.NAME, "email").send_keys("info.24.7express.logistics@gmail.com")
    self.driver.find_element(By.NAME, "password").send_keys("24/7Express#")
    self.driver.find_element(By.ID, "submit-login-button").click()
    print("Авторизация выполнена")
    time.sleep(5)


