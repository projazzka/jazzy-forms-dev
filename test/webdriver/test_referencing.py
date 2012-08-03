from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
from selenium.common.exceptions import NoSuchElementException
import unittest, time, re

class Referencing(unittest.TestCase):
    def setUp(self):
        self.driver = webdriver.Firefox()
        self.driver.implicitly_wait(30)
        self.base_url = "http://blankito.local/workspace/wpbay/wp/"
    
    def test_normal(self):
        driver = self.driver
        driver.get(self.base_url + "referencing/")
        self.assertEqual("123.45", driver.find_element_by_id("jzzf_24_b").get_attribute("value"))
        self.assertEqual("$123.45", driver.find_element_by_id("jzzf_24_c").get_attribute("value"))
        self.assertEqual("$123.45", driver.find_element_by_id("jzzf_24_d").get_attribute("value"))
        self.assertEqual("#REF!", driver.find_element_by_id("jzzf_24_e").get_attribute("value"))
        
        self.assertEqual("You've chosen Apples", driver.find_element_by_id("jzzf_24_o1").get_attribute("value"))
        self.assertEqual("Texas Instruments", driver.find_element_by_id("jzzf_24_o2").get_attribute("value"))
        self.assertEqual("#REF!", driver.find_element_by_id("jzzf_24_o3").get_attribute("value"))
        self.assertEqual("#REF!", driver.find_element_by_id("jzzf_24_o4").get_attribute("value"))
    
    def tearDown(self):
        self.driver.quit()

if __name__ == "__main__":
    unittest.main()
