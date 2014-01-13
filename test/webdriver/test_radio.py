from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
from selenium.common.exceptions import NoSuchElementException
import unittest, time, re

class Radio(unittest.TestCase):
    def setUp(self):
        self.driver = webdriver.Firefox()
        self.driver.implicitly_wait(30)
        self.base_url = "http://blankito.local/workspace/wpbay/wp/"
    
    def test_radio(self):
        driver = self.driver
        driver.get(self.base_url + "radio/")

        self.assertRegexpMatches(driver.find_element_by_css_selector("BODY").text, r"^[\s\S]*No options[\s\S]*$")
        self.assertTrue(driver.find_element_by_xpath("//ul[@id=\"jzzf_5_element_2\"]//input[1]").is_selected())
        self.assertTrue(driver.find_element_by_xpath("//ul[@id=\"jzzf_5_element_number_three\"]/li[2]/input").is_selected())
        self.assertTrue(driver.find_element_by_xpath("//ul[@id=\"jzzf_5_fourth\"]/li[3]/input").is_selected())
        self.assertEqual("0", driver.find_element_by_id("jzzf_5_first_out").get_attribute("value"))
        self.assertEqual("0", driver.find_element_by_id("jzzf_5_second_out").get_attribute("value"))
        self.assertEqual("22", driver.find_element_by_id("jzzf_5_third_out").get_attribute("value"))
        self.assertEqual("30", driver.find_element_by_id("jzzf_5_fourth_out").get_attribute("value"))
        self.assertEqual("yes", driver.find_element_by_id("jzzf_5_fifth_out").get_attribute("value"))

        driver.find_element_by_xpath("(//input[@name='jzzf_5_element_2'])[2]").click()

        self.assertEqual("0", driver.find_element_by_id("jzzf_5_second_out").get_attribute("value"))
        driver.find_element_by_name("jzzf_5_element_number_three").click()
        self.assertEqual("11", driver.find_element_by_id("jzzf_5_third_out").get_attribute("value"))
        driver.find_element_by_xpath("(//input[@name='jzzf_5_fourth'])[2]").click()
        self.assertEqual("20", driver.find_element_by_id("jzzf_5_fourth_out").get_attribute("value"))
        driver.find_element_by_name("jzzf_5_fourth").click()
        self.assertEqual("10", driver.find_element_by_id("jzzf_5_fourth_out").get_attribute("value"))
        driver.find_element_by_id("jzzf_5_fifth-2").click()
        self.assertEqual("no", driver.find_element_by_id("jzzf_5_fifth_out").get_attribute("value"))
        driver.find_element_by_id("jzzf_5_fifth-3").click()
        self.assertEqual("not sure", driver.find_element_by_id("jzzf_5_fifth_out").get_attribute("value"))
    
    def tearDown(self):
        self.driver.quit()

if __name__ == "__main__":
    unittest.main()
