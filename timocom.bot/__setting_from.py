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

    fromSelectOpt = data_data["fromSelectOpt"]
    print(' ---> FROM:', fromSelectOpt)
    #//*[@id="filterFolderForm"]/div[1]/div/div[1]/div/div[1]/label
    fromSelectOptClick = browser.find_element_by_xpath('//label[@for="'+fromSelectOpt+'"]').click()
    time.sleep(2)
    #3-вариант
    if fromSelectOpt == 'app:cnt:searchForm:fromSelectOpt3':
        as_country = data_data["as_country"]
        as_zip = data_data["as_zip"]
        as_radius = data_data["as_radius"]

        browser.find_element_by_xpath('//*[@id="app:cnt:searchForm:startGeoZone:country"]/div[1]').click()
        time.sleep(2)
        inputElementCountry = browser.find_element_by_xpath('//*[@id="app:cnt:searchForm:startGeoZone:country"]/div[2]/div[1]/div/input')
        inputElementCountry.send_keys(as_country)
        time.sleep(2)
        inputElementCountry.send_keys(Keys.ENTER)
        time.sleep(2)
        inputElementZip = browser.find_element_by_id('app:cnt:searchForm:startGeoZone:zip')
        inputElementZip.clear()
        time.sleep(2)
        inputElementZip.send_keys(as_zip)
        time.sleep(2)
        inputElementRadius = browser.find_element_by_id('app:cnt:searchForm:startGeoZone:radius')
        inputElementRadius.clear()
        time.sleep(2)
        inputElementRadius.send_keys(Keys.CONTROL, "a")
        time.sleep(2)
        inputElementRadius.send_keys(Keys.BACKSPACE)
        time.sleep(2)
        inputElementRadius.send_keys(as_radius)
        time.sleep(2)
        #inputElementRadius.send_keys(Keys.ENTER)
        time.sleep(3)

    return('ok')
