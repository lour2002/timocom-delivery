import json
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
from selenium.webdriver.support import expected_conditions as EC

def set_setting(browser, json_data):
    data_data = json.loads(json_data)

    freightSelectOpt = data_data["freightSelectOpt"]
    print(' ---> Selection of freight:', freightSelectOpt)

    toSelectOptClick = browser.find_element_by_xpath('//label[@for="'+freightSelectOpt+'"]').click()
    time.sleep(1)

    #вариант 2 с выбором параметров
    if freightSelectOpt == 'app:cnt:searchForm:freightSelectOpt2':
        length_min = data_data["length_min"]
        length_max = data_data["length_max"]
        weight_min = data_data["weight_min"]
        weight_max = data_data["weight_max"]

        #Express loads only -> NO CHECK
        try:
            express_loads_only = browser.find_element_by_xpath('//*[@id="app:cnt:searchForm:expressLoad"]/div[2][contains(@class, "ui-state-active")]').click()
            print('Express loads only: CHECK')
            time.sleep(1)
        except NoSuchElementException:
            print('Express loads only: NO CHECK')

        #ADR -> NO CHECK
        try:
            express_loads_only = browser.find_element_by_xpath('//*[@id="app:cnt:searchForm:adr"]/div[2][contains(@class, "ui-state-active")]').click()
            print('ADR: CHECK')
            time.sleep(1)
        except NoSuchElementException:
            print('ADR: NO CHECK')
        #Other body types possible -> CHECK
        try:
            body_types_possible = browser.find_element_by_xpath('//*[@id="app:cnt:searchForm:alterBodyType"]/div[2][contains(@class, "ui-state-active")]')
            print('Other body types possible: CHECK')
        except NoSuchElementException:
            try:
                body_types_possible = browser.find_element_by_xpath('//*[@id="app:cnt:searchForm:alterBodyType"]/div[2]').click()
                print('Other body types possible: NO CHECK')
                time.sleep(1)
            except NoSuchElementException:
                print('Other body types possible: NO FIND')
        #ADR -> NO CHECK
        try:
            adr = browser.find_element_by_xpath('//*[@id="app:cnt:searchForm:adr"]/div[2][contains(@class, "ui-state-active")]').click()
            print('ADR: CHECK')
            time.sleep(1)
        except NoSuchElementException:
            print('ADR: NO CHECK')
        #vehicle type
        print('vehicle type: search')
        while 1==1:
            try:
                type_of_body = browser.find_element_by_xpath('//*[@id="app:cnt:searchForm:vehicleType"]/div[1]/div[1]/span/div[1]/span').click()
                print(' ... remove "vehicle type"')
                time.sleep(1)
            except NoSuchElementException:
                break
        #Type of body
        print('Type of body: search')
        while 1==1:
            try:
                type_of_body = browser.find_element_by_xpath('//*[@id="app:cnt:searchForm:vehicleBodies"]/div[1]/div[1]/span/div/span').click()
                print(' ... remove "Type of body"')
                time.sleep(1)
            except NoSuchElementException:
                break
        #Characteristics
        print('Characteristics: search')
        while 1==1:
            try:
                type_of_body = browser.find_element_by_xpath('//*[@id="vehicleProperties"]/div[1]/span').click()
                print(' ... remove "Characteristics"')
                time.sleep(1)
            except NoSuchElementException:
                break

        #length_min
        if len(length_min) > 0 and length_min != '0.00':
            input_length_min = browser.find_element_by_id('app:cnt:searchForm:minFreightLength')
            input_length_min.clear()
            time.sleep(1)
            input_length_min.send_keys(Keys.CONTROL, "a")
            time.sleep(1)
            input_length_min.send_keys(Keys.BACKSPACE)
            time.sleep(2)
            input_length_min.send_keys(length_min)
            time.sleep(1)
        #length_max
        if len(length_max) > 0 and length_max != '0.00':
            input_length_max = browser.find_element_by_id('app:cnt:searchForm:maxFreightLength')
            input_length_max.clear()
            time.sleep(1)
            input_length_max.send_keys(Keys.CONTROL, "a")
            time.sleep(1)
            input_length_max.send_keys(Keys.BACKSPACE)
            time.sleep(2)
            input_length_max.send_keys(length_max)
            time.sleep(1)
        #weight_min
        if len(weight_min) > 0 and weight_min != '0.00':
            input_weight_min = browser.find_element_by_id('app:cnt:searchForm:minFreightWeight')
            input_weight_min.clear()
            time.sleep(1)
            input_weight_min.send_keys(Keys.CONTROL, "a")
            time.sleep(1)
            input_weight_min.send_keys(Keys.BACKSPACE)
            time.sleep(2)
            input_weight_min.send_keys(weight_min)
            time.sleep(1)
        #weight_max
        if len(weight_max) > 0 and weight_max != '0.00':
            input_weight_max = browser.find_element_by_id('app:cnt:searchForm:maxFreightWeight')
            input_weight_max.clear()
            time.sleep(1)
            input_weight_max.send_keys(Keys.CONTROL, "a")
            time.sleep(1)
            input_weight_max.send_keys(Keys.BACKSPACE)
            time.sleep(2)
            input_weight_max.send_keys(weight_max)
            time.sleep(1)

    return('ok')
