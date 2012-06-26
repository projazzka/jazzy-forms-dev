from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
from selenium.common.exceptions import NoSuchElementException
import unittest, time, re

class Number(unittest.TestCase):
    def setUp(self):
        self.driver = webdriver.Firefox()
        self.driver.implicitly_wait(30)
        self.base_url = "http://blankito.local/workspace/wpbay/wp/"
    
    def test_number(self):
        driver = self.driver
        driver.get(self.base_url + "number/")
        self.assertEqual("", driver.find_element_by_id("jzzf_3_first").get_attribute("value"))
        self.assertEqual("10", driver.find_element_by_id("jzzf_3_element_2").get_attribute("value"))
        self.assertEqual("10", driver.find_element_by_id("jzzf_3_element_number_three").get_attribute("value"))
        self.assertEqual("", driver.find_element_by_id("jzzf_3_first_out").get_attribute("value"))
        self.assertEqual("10", driver.find_element_by_id("jzzf_3_second_out").get_attribute("value"))
        self.assertEqual("11.2", driver.find_element_by_id("jzzf_3_third_out").get_attribute("value"))

        driver.find_element_by_id("jzzf_3_first").clear()
        driver.find_element_by_id("jzzf_3_first").send_keys("1.234\t")

        self.assertEqual("1.234", driver.find_element_by_id("jzzf_3_first_out").get_attribute("value"))

        driver.find_element_by_id("jzzf_3_element_2").clear()
        driver.find_element_by_id("jzzf_3_element_2").send_keys("4.321\t")

        self.assertEqual("4.321", driver.find_element_by_id("jzzf_3_second_out").get_attribute("value"))

        driver.find_element_by_id("jzzf_3_element_number_three").clear()
        driver.find_element_by_id("jzzf_3_element_number_three").send_keys("100\t")

        self.assertEqual("112", driver.find_element_by_id("jzzf_3_third_out").get_attribute("value"))
    
    def tearDown(self):
        self.driver.quit()

if __name__ == "__main__":
    unittest.main()
