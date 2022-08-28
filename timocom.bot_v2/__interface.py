import time

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

def close_chat(browser):
    try:
        chat_open = browser.find_element_by_xpath('//*[@id="msg_settings"]/li[2]/a')
        if chat_open.is_displayed():
            browser.execute_script("arguments[0].click();", chat_open)
            print(' ... свернули панель чата')
            chat = 'open'
    except NoSuchElementException:
        chat = 'closed'
    except TimeoutException:
        chat = 'closed'

#new offers - выводить не только новые
def new_offers_off(browser):
    #кнопка - выводить только новые
    try:
        inputNewOffers = browser.find_element_by_xpath('//*[@id="app:cnt:searchForm:newOffers"]/div[2][contains(@class, "ui-state-active")]').click()
        print(' => Показыать только новые - TRUE')
        print(' ... отключаем')
    except NoSuchElementException:
        print(' => Показыать только новые - FALSE')

    time.sleep(2)
    return('ok')

def new_offers_on(browser):
    #кнопка - выводить только новые
    try:
        inputNewOffers = browser.find_element_by_xpath('//*[@id="app:cnt:searchForm:newOffers"]/div[2][contains(@class, "ui-state-active")]')
        print(' => Показыать только новые - TRUE')
    except NoSuchElementException:
        print(' => Показыать только новые - FALSE')
        print(' ... включаем')
        try:
            inputNewOffers = browser.find_element_by_xpath('//*[@id="app:cnt:searchForm:newOffers"]/div[2]').click()
        except NoSuchElementException:
            print(' ... проблема - НЕ СМОГЛИ АКТИВИРОВАТЬ ТОЛЬКО НОВЫЕ')
    time.sleep(2)
    return('ok')

#закрытие старых настроек при старте системы
def close_old_search_tab(browser):
    print('=> Поиск старых настроек')
    while 1 == 1:
        try:
            search_close_tab = browser.find_element_by_xpath('//*[@title="Delete search"]')
            if search_close_tab.is_displayed():
                print(' ... нашли старые настройки - закрываем')
                search_close_tab.click()
                time.sleep(2)
            else:
                print(' ... лишних закладок поиска больше не найдено')
                break
        #except ElementNotInteractableException:
            #print(' ... поспешили')
        except NoSuchElementException:
            print(' ... лишних закладок поиска не найдено')
            break
    return('ok')

#добавление новых вкладок поиска
def add_new_search_tab(browser, count_tabs):
    print('=> Для работы необходимо ', count_tabs, 'вкладок поиска')
    while 1 == 1:
        #считаем кнопки "закрыть вкладку" и понимаем, сколько есть на данный момент
        try:
            search_close_tabs = browser.find_elements_by_xpath('//*[@title="Delete search"]')
            if len(search_close_tabs) < count_tabs:#если не хватает, жмем добавить
                search_close_add_tab = browser.find_element_by_xpath('//li[@title="New search"]')
                if search_close_add_tab.is_displayed():
                    search_close_add_tab.click()
                    print(' ... Добавили вкладку поиска')
                    time.sleep(3)
                else:
                    print(' ... ERROR: Невозможно добавить вкладку поиска! | is_displayed')
                    break
            else:
                print(' ... Необходимое колличество вкладок поиска создано')
                break
        except NoSuchElementException:
            print(' ... ERROR: Невозможно добавить вкладку поиска! | NoSuchElementException')
            break

    return(len(search_close_tabs))

#Переход к конкретной вкладке
def open_job_tab(browser, number_tab):
    status_open = 0
    print('=> Переходм ко вкладке (0-4):', number_tab)
    #собираем в кучу вкладки
    tab_search = browser.find_elements_by_class_name('tc-tab-contents')
    #print('Вкладки', len(tab_search))
    current_tab = tab_search[number_tab].click()#кликаем
    #time.sleep(1)
    #проверим переход во вкладку
    error_count = 0 #число допустимых ошибок при поиске
    while error_count != 3:
        time.sleep(1)
        try:#ищем саму вкладку
            check1 = browser.find_elements_by_class_name('tc-tab-contents')
            current_tab = check1[number_tab]
            try:#проверяем наличие иконки - как признак открытия вкладки
                check2 = current_tab.find_elements_by_class_name('tc-icon-small')
                #print(len(check2))
                if len(check2) > 0:
                    print(' ... поиск вкладки - OK')
                    status_open = 1
                    break
                else:
                    print(' ... поиск вкладки - неудачно')
            except NoSuchElementException:
                print('не нашли иконку - признак [2]')
            except StaleElementReferenceException:
                print('не нашли элемент на странице [2]')
        except NoSuchElementException:
            print('не нашли иконку - признак [1]')
        except StaleElementReferenceException:
            print('не нашли элемент на странице [1]')
        error_count = error_count+1
        #print('error_count:', error_count)

    return(status_open)

#проверяем открыты ли настройки и если нет, то открываем
def check_open_setting(browser, number_tab):
    print('=> Проверка открытия настроек')
    status_open_setting = 0
    error_count = 0 #число допустимых ошибок при поиске
    while error_count != 3:
        time.sleep(1)
        try:
            search_job_page = browser.find_element_by_id('filterFolderSummary')
            if search_job_page.is_displayed():
                print(' ... настройки закрыты - открываем')
                tab_search = browser.find_elements_by_class_name('tc-tab-contents')
                #print('Вкладки', len(tab_search))
                current_tab = tab_search[number_tab].click()#кликаем
                time.sleep(2)
                status_open_setting = 0
            else:
                status_open_setting = 1
        except NoSuchElementException:
            status_open_setting = 0
        except TimeoutException:
            status_open_setting = 0
        error_count = error_count+1
    return(status_open_setting)
