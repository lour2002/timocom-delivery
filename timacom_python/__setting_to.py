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

    toSelectOpt = data_data["toSelectOpt"]
    print(' ---> TO:', toSelectOpt)
    #//*[@id="filterFolderForm"]/div[1]/div/div[1]/div/div[1]/label
    toSelectOptClick = browser.find_element_by_xpath('//label[@for="'+toSelectOpt+'"]').click()
    time.sleep(1)
    #2-вариант
    if toSelectOpt == 'app:cnt:searchForm:toSelectOpt2':
        print(' => Кол-во направлений', len(data_data["toSelectOptArray"]))
        #закрываем страны, если есть - 4 клика на первый минус
        try:
            for numberClose in range(4):
                browser.find_element_by_xpath('//*[@id="app:cnt:searchForm:destinationZip:destinationZipRows:0:minusBtn"]/span').click()
                time.sleep(1)
        except NoSuchElementException:
            print(' ! NoSuchElementException')
        #перебор значений
        if len(data_data["toSelectOptArray"]) > 0:
            counter = 0
            for addLine in data_data["toSelectOptArray"]:
                print(' ===>', addLine["as_country_to"])
                if counter == 0:#если первое значение, то поле добавлять не надо
                    browser.find_element_by_xpath('//*[@id="app:cnt:searchForm:destinationZip:destinationZipRows:0:countryZip"]/div[1]').click()
                    time.sleep(1)
                    inputElementCountry = browser.find_element_by_xpath('//*[@id="app:cnt:searchForm:destinationZip:destinationZipRows:0:countryZip"]/div[2]/div[1]/div/input')
                    inputElementCountry.send_keys(addLine["as_country_to"])
                    time.sleep(2)
                    inputElementCountry.send_keys(Keys.ENTER)
                    time.sleep(1)
                    #post1
                    if len(addLine["post1"]) > 0:
                        inputElementZip1 = browser.find_element_by_id('app:cnt:searchForm:destinationZip:destinationZipRows:0:zip1')
                        inputElementZip1.clear()
                        time.sleep(1)
                        inputElementZip1.send_keys(addLine["post1"])
                        time.sleep(1)
                    #post2
                    if len(addLine["post2"]) > 0:
                        inputElementZip1 = browser.find_element_by_id('app:cnt:searchForm:destinationZip:destinationZipRows:0:zip2')
                        inputElementZip1.clear()
                        time.sleep(1)
                        inputElementZip1.send_keys(addLine["post2"])
                        time.sleep(1)
                    #post3
                    if len(addLine["post3"]) > 0:
                        inputElementZip1 = browser.find_element_by_id('app:cnt:searchForm:destinationZip:destinationZipRows:0:zip3')
                        inputElementZip1.clear()
                        time.sleep(1)
                        inputElementZip1.send_keys(addLine["post3"])
                        time.sleep(1)
                else:
                    counter2 = counter-1
                    #добавляем поле
                    browser.find_element_by_xpath('//*[@id="app:cnt:searchForm:destinationZip:destinationZipRows:'+str(counter2)+':plusBtn"]').click()
                    time.sleep(1)
                    #app:cnt:searchForm:destinationZip:destinationZipRows:1:countryZip
                    browser.find_element_by_xpath('//*[@id="app:cnt:searchForm:destinationZip:destinationZipRows:'+str(counter)+':countryZip"]/div[1]').click()
                    time.sleep(1)
                    inputElementCountry = browser.find_element_by_xpath('//*[@id="app:cnt:searchForm:destinationZip:destinationZipRows:'+str(counter)+':countryZip"]/div[2]/div[1]/div/input')
                    inputElementCountry.send_keys(addLine["as_country_to"])
                    time.sleep(2)
                    inputElementCountry.send_keys(Keys.ENTER)
                    time.sleep(2)
                    #post1
                    if len(addLine["post1"]) > 0:
                        inputElementZip1 = browser.find_element_by_id('app:cnt:searchForm:destinationZip:destinationZipRows:'+str(counter)+':zip1')
                        inputElementZip1.clear()
                        time.sleep(1)
                        inputElementZip1.send_keys(addLine["post1"])
                        time.sleep(1)
                    #post2
                    if len(addLine["post2"]) > 0:
                        inputElementZip1 = browser.find_element_by_id('app:cnt:searchForm:destinationZip:destinationZipRows:'+str(counter)+':zip2')
                        inputElementZip1.clear()
                        time.sleep(1)
                        inputElementZip1.send_keys(addLine["post2"])
                        time.sleep(1)
                    #post3
                    if len(addLine["post3"]) > 0:
                        inputElementZip1 = browser.find_element_by_id('app:cnt:searchForm:destinationZip:destinationZipRows:'+str(counter)+':zip3')
                        inputElementZip1.clear()
                        time.sleep(1)
                        inputElementZip1.send_keys(addLine["post3"])
                        time.sleep(1)
                counter = counter+1

    return('ok')
