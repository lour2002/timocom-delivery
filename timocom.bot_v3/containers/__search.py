import base64
import time
import requests

from selenium.common import NoSuchElementException
from selenium.webdriver.common.by import By


def search(self, data, url):
    send_url = str(url) + '/api/send_order'
    id_task = data['id_task']

    # Нажать на кнопку поиск
    self.driver.find_element(By.XPATH, "//button[contains(., 'Search')]").click()
    time.sleep(2)
    print("Поиск выполнен")

    try:
        # Нажимаем на первый найденный эллемент и ждем
        self.driver.find_elements(By.CSS_SELECTOR, "[data-testid^='OfferTable/table_body_row_']")[0].click()
        time.sleep(2)
        while True:
            # Получаем текущий url страницы (идентичный тому, что и при нажатии кнопки share)
            offer_id = self.driver.current_url.split(',')
            # Содержимое заказа кодируем в base64
            content_order = self.driver.find_element(By.CSS_SELECTOR,
                                                        '[data-testid="FreightSearchView/container"] > div > div:nth-child(2) > div:nth-child(2)')
            content_order_html = content_order.get_attribute('innerHTML')
            content_order_64 = base64.b64encode(content_order_html.encode('utf-8'))
            print('---> Отправка данных на управляющий сервер...')
            print('---->', offer_id[0])
            # Отправляем запроос н сервер
            res = requests.post(send_url, data={'id_task': id_task, 'offer_id': offer_id[0],
                                                'content_order_64': content_order_64}, verify=False)

            # Находим элемент и проверяем, не заблокирован ли он
            element = self.driver.find_element(By.CSS_SELECTOR,
                                               '[data-testid="TitleToolbarControls/arrowDownIcon"]')
            disabled = element.get_attribute('disabled')
            # Если у заказа имеется атрибут disabled, это последний заказ, отправляем данные и завершаем выполнение
            if disabled:
                print("Финиш!")
                # Закрываем окно заказов
                self.driver.find_element(By.CSS_SELECTOR,
                                         '[data-expanded="true"] > div:nth-child(2) [role="button"]').click()
                break
            else:
                print("Следующий заказ")
                element.click()

    except NoSuchElementException:
        print("Поиск ничего не нашел. Финиш!")

    time.sleep(100)
