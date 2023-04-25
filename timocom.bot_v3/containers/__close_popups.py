import time
from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions
from selenium.webdriver.support.wait import WebDriverWait


def close_windows(self):
    try:
        self.driver.find_element(By.CSS_SELECTOR, ".JoyRide_customerFooter__iSZGR .Checkbox_checkboxInput__0qIbn")
        WebDriverWait(self.driver, 5).until(expected_conditions.presence_of_element_located((By.CSS_SELECTOR, ".JoyRide_customerFooter__iSZGR .Checkbox_checkboxInput__0qIbn")))
    except:
        pass

    try:
        #Чекбокс Do not show this again
        self.driver.find_element(By.XPATH, "//input[@name='']").click()
        #Кнопка Next
        self.driver.find_element(By.XPATH, "//button[contains(.,'Next')]").click()
        time.sleep(2)
    except:
        pass

    #Проверка наличия кнопки ок в окне Allow browser notifications, если окно не появилось, пропускаем
    try:
        self.driver.find_element(By.CSS_SELECTOR, "#msg_desktop_notification_modal_ok").click()
    except:
        pass
    # Проверка наличия кнопки закрытия чата, если чат не появился, пропускаем
    try:
        self.driver.find_element(By.CSS_SELECTOR, "#msg_settings > li:nth-child(2)").click()
    except:
        pass
    print("Все всплывающие окна закрыты")
