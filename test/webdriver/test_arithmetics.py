from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
from selenium.common.exceptions import NoSuchElementException
import unittest, time, re

class Arithmetics(unittest.TestCase):
    def setUp(self):
        self.driver = webdriver.Firefox()
        self.driver.implicitly_wait(30)
        self.base_url = "http://blankito.local/workspace/wpbay/wp/"
    
    def test_arithmetics(self):
        driver = self.driver
        driver.get(self.base_url + "arithmetics/")
        self.assertEqual("7", driver.find_element_by_id("jzzf_10_sum").get_attribute("value"))
        self.assertEqual("-1", driver.find_element_by_id("jzzf_10_difference").get_attribute("value"))
        self.assertEqual("12", driver.find_element_by_id("jzzf_10_product").get_attribute("value"))
        self.assertEqual("0.75", driver.find_element_by_id("jzzf_10_division").get_attribute("value"))
        self.assertEqual("81", driver.find_element_by_id("jzzf_10_exponentiation").get_attribute("value"))
        self.assertEqual("27", driver.find_element_by_id("jzzf_10_cube").get_attribute("value"))
        self.assertEqual("11", driver.find_element_by_id("jzzf_10_precedence").get_attribute("value"))
        self.assertEqual("20", driver.find_element_by_id("jzzf_10_association").get_attribute("value"))
        driver.find_element_by_id("jzzf_10_first").clear()
        driver.find_element_by_id("jzzf_10_first").send_keys("-3.5\t")
        driver.find_element_by_id("jzzf_10_second").clear()
        driver.find_element_by_id("jzzf_10_second").send_keys("3\t")
        self.assertEqual("-6.5", driver.find_element_by_id("jzzf_10_difference").get_attribute("value"))
        self.assertEqual("-10.5", driver.find_element_by_id("jzzf_10_product").get_attribute("value"))
        self.assertEqual("-1.166666667", driver.find_element_by_id("jzzf_10_division").get_attribute("value"))
        self.assertEqual("-42.875", driver.find_element_by_id("jzzf_10_exponentiation").get_attribute("value"))
        self.assertEqual("-42.875", driver.find_element_by_id("jzzf_10_cube").get_attribute("value"))
        self.assertEqual("2.5", driver.find_element_by_id("jzzf_10_precedence").get_attribute("value"))
        self.assertEqual("-4.5", driver.find_element_by_id("jzzf_10_association").get_attribute("value"))
    
    def tearDown(self):
        self.driver.quit()

if __name__ == "__main__":
    unittest.main()
