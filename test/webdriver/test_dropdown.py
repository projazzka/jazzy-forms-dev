from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
from selenium.common.exceptions import NoSuchElementException
import unittest, time, re

class Dropdown(unittest.TestCase):
    def setUp(self):
        self.driver = webdriver.Firefox()
        self.driver.implicitly_wait(30)
        self.base_url = "http://blankito.local/workspace/wpbay/wp/"
    
    def test_dropdown(self):
        driver = self.driver
        driver.get(self.base_url + "dropdown/")

        self.assertEqual("0", driver.find_element_by_id("jzzf_4_first_out").get_attribute("value"))
        self.assertEqual("0", driver.find_element_by_id("jzzf_4_second_out").get_attribute("value"))
        self.assertEqual("22", driver.find_element_by_id("jzzf_4_third_out").get_attribute("value"))
        self.assertEqual("30", driver.find_element_by_id("jzzf_4_fourth_out").get_attribute("value"))
        self.assertEqual("Yes", driver.find_element_by_id("jzzf_4_fifth_out").get_attribute("value"))
        self.assertEqual("", driver.find_element_by_id("jzzf_4_labelfirst").get_attribute("value"))
        self.assertEqual("0", driver.find_element_by_id("jzzf_4_selectedfirst").get_attribute("value"))
        self.assertEqual("Option B", driver.find_element_by_id("jzzf_4_labelthird").get_attribute("value"))
        self.assertEqual("2", driver.find_element_by_id("jzzf_4_selectedthird").get_attribute("value"))
        
        driver.find_element_by_css_selector("#jzzf_4_second option:nth-of-type(2)").click()
        self.assertEqual("0", driver.find_element_by_id("jzzf_4_first_out").get_attribute("value"))
        
        driver.find_element_by_css_selector("#jzzf_4_third option:nth-of-type(1)").click()
        self.assertEqual("11", driver.find_element_by_id("jzzf_4_third_out").get_attribute("value"))

        driver.find_element_by_css_selector("#jzzf_4_third option:nth-of-type(2)").click()
        self.assertEqual("22", driver.find_element_by_id("jzzf_4_third_out").get_attribute("value"))

        driver.find_element_by_css_selector("#jzzf_4_fourth option:nth-of-type(1)").click()
        self.assertEqual("10", driver.find_element_by_id("jzzf_4_fourth_out").get_attribute("value"))

        driver.find_element_by_css_selector("#jzzf_4_fourth option:nth-of-type(2)").click()
        self.assertEqual("20", driver.find_element_by_id("jzzf_4_fourth_out").get_attribute("value"))

        driver.find_element_by_css_selector("#jzzf_4_fourth option:nth-of-type(3)").click()
        self.assertEqual("30", driver.find_element_by_id("jzzf_4_fourth_out").get_attribute("value"))

        driver.find_element_by_css_selector("#jzzf_4_fifth option:nth-of-type(2)").click()
        self.assertEqual("No", driver.find_element_by_id("jzzf_4_fifth_out").get_attribute("value"))
        
        driver.find_element_by_css_selector("#jzzf_4_fifth option:nth-of-type(3)").click()
        self.assertEqual("Not sure", driver.find_element_by_id("jzzf_4_fifth_out").get_attribute("value"))
    
    def tearDown(self):
        self.driver.quit()

if __name__ == "__main__":
    unittest.main()
