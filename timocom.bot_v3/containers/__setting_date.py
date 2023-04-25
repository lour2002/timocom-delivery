import time
from selenium.webdriver.common.by import By


def setting_date(self, data):

    selected_datas = data['individual_days'].replace(".", "/")
    # DATE
    self.driver.find_element(By.CSS_SELECTOR,
                             '[data-testid="LoadingDateFilter/periodDateFilter-input-start"]').send_keys(f'{selected_datas}')
    self.driver.find_element(By.CSS_SELECTOR,
                             '[data-testid="LoadingDateFilter/periodDateFilter-input-end"]').send_keys(f'{selected_datas}')
    print("Поля data заполнены")

