import os
import json
import time
import base64
import requests

from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.common.exceptions import NoSuchElementException
from selenium.common.exceptions import TimeoutException
from selenium.common.exceptions import InvalidArgumentException
from selenium.common.exceptions import ElementNotInteractableException
from selenium.common.exceptions import StaleElementReferenceException
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.support import expected_conditions as EC

import __getsetting as getsetting

def get_new_orders(browser, id_task, domain_key , number_tab, version_task, user_key):
    send_url = str(domain_key)+'/api/send_order'
    print('|==>> id_task:', id_task)
    report_data = '0'
    print(' ... поиск предложений')
    try:
        search_block_orders = browser.find_element_by_class_name('tc-jsonTable-results')
        block_orders_inner_html = search_block_orders.find_elements_by_xpath("//*[@d-num]")
        if len(block_orders_inner_html) > 0:#если в списке есть задачи
            for i1 in block_orders_inner_html:
                order_line = i1.find_elements_by_xpath("//div[@title]")
                line = i1.text
                if len(line) != 0:#не пустая строка
                    print(' ... предложение найдено, переходим к нему')
                    i1.click()
                    time.sleep(5)
                    try:
                        next_page = 'yes'
                        index = 0
                        while next_page!= 'no':
                            # Проверяем изменились ли настройки
                            setting_tab = getsetting.get_setting(number_tab, domain_key, user_key)

                            if version_task != setting_tab['version_task']:
                                print(' ---> Настройки изменились - Выход...')
                                time.sleep(3)
                                next_page = 'no'
                                break

                            # получаем хитрый ИД
                            browser.find_element_by_xpath('//*[@id="app:cnt:searchDetail:navBar:shareOfferBtn"]').click()
                            time.sleep(5)
                            input = browser.find_element_by_id('app:cnt:searchDetail:shareOfferUrl')
                            offer_id = input.get_attribute('value')
                            browser.find_element_by_xpath('//*[@id="app:cnt:searchDetail:shareOfferDialog"]/div[1]/a').click()
                            time.sleep(5)
                            # получаем контент
                            content_order = browser.find_element_by_id('app:cnt:searchDetail')
                            content_order_html = content_order.get_attribute('innerHTML')
                            content_order_64 = base64.b64encode(bytes(content_order_html, 'utf-8'))
                            print( '---> Отправка данных на управляющий сервер...')
                            print('---->', offer_id)
                            #print('---->', content_order_64)
                            #res = requests.post(send_url, data={'id_task': id_task, 'offer_id': offer_id}, verify=False)

                            index = index + 1
                            res = requests.post(send_url, data={'id_task': id_task, 'offer_id': offer_id, 'content_order_64': content_order_64}, verify=False)

                            #поиска - ДАЛЬШЕ
                            try:
                                browser.find_element_by_xpath('//*[@id="app:cnt:searchDetail:navBar:nextOfferBtn"][contains(@class, "ui-state-disabled")]')
                                print(' ---| дальше некуда, возвращаемся')
                                browser.find_element_by_xpath('//*[@id="app:cnt:searchDetail:navBar:backToSearchBtn"]').click()
                                time.sleep(5)
                                next_page = 'no'
                                break
                            except NoSuchElementException:
                                browser.find_element_by_xpath('//*[@id="app:cnt:searchDetail:navBar:nextOfferBtn"]').click()
                                time.sleep(5)
                                print(' ---> идем дальше')
                        report_data = '5'
                        time.sleep(5)
                    except NoSuchElementException:
                        print('Error | No content | NoSuchElementException')
                        report_data = '5'
                    except TimeoutException:
                        print('Error | No content | TimeoutException')
                        report_data = '5'
                    break
            report_data = '1'
        else:
            print(' ... список предложений пуст')
            report_data = '1'
    except NoSuchElementException:
        print('Error | NoSuchElementException')
        report_data = '9'
    except TimeoutException:
        print('Error | TimeoutException')
        report_data = '9'


    return(report_data)
