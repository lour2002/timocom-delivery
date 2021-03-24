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

    dateSelectOpt = data_data["dateSelectOpt"]
    print(' ---> Date:', dateSelectOpt)

    toDateSelectOptClick = browser.find_element_by_xpath('//label[@for="'+dateSelectOpt+'"]').click()
    time.sleep(1)
    #2-вариант - 1 дата
    if dateSelectOpt == 'app:cnt:searchForm:dateSelectOpt2':
        print(' ===> Individual days')
        individual_days = data_data["individual_days"]
        inputElementDate = browser.find_element_by_id('app:cnt:searchForm:pickedDates:rows:0:pickedDate_input')
        inputElementDate.clear()
        time.sleep(1)
        inputElementDate.send_keys(Keys.CONTROL, "a")
        time.sleep(1)
        inputElementDate.send_keys(Keys.BACKSPACE)
        time.sleep(2)
        inputElementDate.send_keys(individual_days)
        time.sleep(1)
    #3-вариант - период
    if dateSelectOpt == 'app:cnt:searchForm:dateSelectOpt3':
        print(' ===> Period')
        period_start = data_data["period_start"]
        period_stop = data_data["period_stop"]
        #period_start
        inputElementDate = browser.find_element_by_id('app:cnt:searchForm:fromPeriod_input')
        inputElementDate.clear()
        time.sleep(1)
        inputElementDate.send_keys(Keys.CONTROL, "a")
        time.sleep(1)
        inputElementDate.send_keys(Keys.BACKSPACE)
        time.sleep(2)
        inputElementDate.send_keys(period_start)
        time.sleep(1)
        #period_stop
        inputElementDate = browser.find_element_by_id('app:cnt:searchForm:toPeriod_input')
        inputElementDate.clear()
        time.sleep(1)
        inputElementDate.send_keys(Keys.CONTROL, "a")
        time.sleep(1)
        inputElementDate.send_keys(Keys.BACKSPACE)
        time.sleep(2)
        inputElementDate.send_keys(period_stop)
        time.sleep(1)

    return('ok')
