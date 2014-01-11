from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
from selenium.common.exceptions import NoSuchElementException
import unittest, time, re

class Checkbox(unittest.TestCase):
    def setUp(self):
        self.driver = webdriver.Firefox()
        self.driver.implicitly_wait(30)
        self.base_url = "http://blankito.local/workspace/wpbay/wp/"
    
    def test_checkbox(self):
        driver = self.driver
        driver.get(self.base_url + "checkbox/")
        self.assertTrue(driver.find_element_by_id("jzzf_6_first").is_selected())
        self.assertFalse(driver.find_element_by_id("jzzf_6_element_2nd").is_selected())
        self.assertTrue(driver.find_element_by_id("jzzf_6_element_three").is_selected())
        self.assertEqual("1", driver.find_element_by_id("jzzf_6_first_out").get_attribute("value"))
        self.assertEqual("0", driver.find_element_by_id("jzzf_6_second_out").get_attribute("value"))
        self.assertEqual("20", driver.find_element_by_id("jzzf_6_third_out").get_attribute("value"))
        self.assertEqual("no", driver.find_element_by_id("jzzf_6_fourth_out").get_attribute("value"))

        driver.find_element_by_id("jzzf_6_first").click()

        self.assertEqual("0", driver.find_element_by_id("jzzf_6_first_out").get_attribute("value"))
        driver.find_element_by_id("jzzf_6_element_2nd").click()
        self.assertEqual("10", driver.find_element_by_id("jzzf_6_second_out").get_attribute("value"))
        driver.find_element_by_id("jzzf_6_element_three").click()
        self.assertEqual("10", driver.find_element_by_id("jzzf_6_third_out").get_attribute("value"))
        driver.find_element_by_id("jzzf_6_fourth").click()
        self.assertEqual("yes", driver.find_element_by_id("jzzf_6_fourth_out").get_attribute("value"))
    
    def tearDown(self):
        self.driver.quit()

if __name__ == "__main__":
    unittest.main()
