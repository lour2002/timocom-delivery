from selenium.webdriver.common.by import By

def setting_requirements(self, data):

    min_length = data['length_min']
    max_length = data['length_max']
    min_weight = data['weight_min']
    max_weight = data['weight_max']

    # requirements
    self.driver.find_element(By.NAME, "minLength").send_keys(f"{min_length}")
    self.driver.find_element(By.NAME, "maxLength").send_keys(f"{max_length}")
    self.driver.find_element(By.NAME, "minWeight").send_keys(f"{min_weight}")
    self.driver.find_element(By.NAME, "maxWeight").send_keys(f"{max_weight}")