import time
from selenium.webdriver.common.by import By


from_country = "AL Albania"
region = "1010 - Tiranë"
to_country = ["AL Albania", "BG Bulgaria", "CN China", "DE Germany", "EG Egypt"]
zip_code = [[12, 23, 34], [23, 12, 43], [14, 16, 18], [22, 42, 62], [11, 15, 18]]
min_length = 0
max_length = 8
min_weight = 0
max_weight = 3
selected_dates = "19/04/2023"


def set_settings(self):
    # FROM
    self.driver.find_element(By.CSS_SELECTOR,
                             "div:nth-child(3) > div > label > span.Label_labelContentWrapper__o7tfl > span > input").click()
    self.driver.find_element(By.CSS_SELECTOR, "#fromGeoFilter\\.countryId").click()
    self.driver.find_element(By.XPATH, f"//div[contains(text(), '{from_country}')]").click()
    self.driver.find_element(By.ID, "fromGeoFilter.geoAutocompleteData").send_keys(f"{region}")
    time.sleep(2)

    # TO
    self.driver.find_element(By.CSS_SELECTOR,
                             "div:nth-child(3) > fieldset > div > div > div > fieldset > div > div > div > div > div:nth-child(2) > div > label > span.Label_labelContentWrapper__o7tfl > span > input").click()
    for i in range(4):
        self.driver.find_element(By.CSS_SELECTOR,
                                 "div:nth-child(3) > fieldset > div > div > div:nth-child(2) > div > div > div.LocationZipFilter_btnGroup__0HjpH > button").click()

    for i in range(5):
        self.driver.find_element(By.ID, f"toZipFilter-country-{i}").click()
        self.driver.find_element(By.XPATH, f"//div[contains(text(), '{to_country[i]}')]").click()
        self.driver.find_element(By.ID, f"toZipFilter-zip1-{i}").send_keys(f"{zip_code[i][0]}")
        self.driver.find_element(By.ID, f"toZipFilter-zip2-{i}").send_keys(f"{zip_code[i][1]}")
        self.driver.find_element(By.ID, f"toZipFilter-zip3-{i}").send_keys(f"{zip_code[i][2]}")

    # requirements
    self.driver.find_element(By.NAME, "minLength").send_keys(f"{min_length}")
    self.driver.find_element(By.NAME, "maxLength").send_keys(f"{max_length}")
    self.driver.find_element(By.NAME, "minWeight").send_keys(f"{min_weight}")
    self.driver.find_element(By.NAME, "maxWeight").send_keys(f"{max_weight}")

    # DATE
    self.driver.find_element(By.CSS_SELECTOR,
                             "fieldset > div > fieldset > div > div > div > div:nth-child(1) > label > span.Label_labelContentWrapper__o7tfl > span > input").click()
    self.driver.find_element(By.CSS_SELECTOR,
                             "div:nth-child(2) > .LoadingDateFilter_loadingDateArea__\\+wI7R .Checkbox_checkboxInput__0qIbn").click()
    self.driver.find_element(By.NAME, "selectedDates.2-startValue").send_keys(f"{selected_dates}")
    self.driver.find_element(By.CSS_SELECTOR, ".SearchFilter_submitButton__773ml").click()
    time.sleep(20)
