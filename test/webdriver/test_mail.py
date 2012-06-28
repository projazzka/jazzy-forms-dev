from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
from log_analyzer import Log_Analyzer
import unittest, re, time, string

class Mail(unittest.TestCase):
    def setUp(self):
        self.driver = webdriver.Firefox()
        self.driver.implicitly_wait(30)
        self.base_url = "http://blankito.local/workspace/wpbay/wp/"
        self.log = Log_Analyzer('/tmp/jzzf.log')
        self.log.clear()
            
    def test_mail(self):
        driver = self.driver
        driver.get(self.base_url + "mail/")

        name = driver.find_element_by_id("jzzf_15_name")
        name.clear()
        name.send_keys("Igor Prochazka")

        email = driver.find_element_by_id("jzzf_15_email")
        email.clear()
        email.send_keys("igor.prochazka@gmail.com")

        driver.find_element_by_id("jzzf_15_send").click()
        
        time.sleep(10)
        
        to = self.log.extract("Email to: ")
        subject = self.log.extract("Email subject: ")
        message = self.log.extract("Email message: ")

        self.assertEquals(to, "Igor Prochazka <igor.prochazka@gmail.com>")
        self.assertEquals(subject, "From Mark. Hi!")
        self.assertEquals(message, """Hello Igor Prochazka,
your price is $10.00.
Inline: 0.5. Direct: 9.00
I will call you at 
Bye,
Mark.""")

    def test_number_input(self):
        number = "902365247";
        
        driver = self.driver
        driver.get(self.base_url + "mail/")

        name = driver.find_element_by_id("jzzf_15_phone")
        
        name.clear()
        name.send_keys(number)

        driver.find_element_by_id("jzzf_15_send").click()
        
        time.sleep(10)
        
        message = self.log.extract("Email message: ")
        self.assertTrue(string.find(message, number) > 0)

    def test_number_input2(self):
        number = "902 365 247";
        
        driver = self.driver
        driver.get(self.base_url + "mail/")

        name = driver.find_element_by_id("jzzf_15_phone")
        
        name.clear()
        name.send_keys(number)

        driver.find_element_by_id("jzzf_15_send").click()
        
        time.sleep(10)
        
        message = self.log.extract("Email message: ")
        self.assertTrue(string.find(message, number) > 0)

    def tearDown(self):
        self.driver.quit()

if __name__ == "__main__":
    unittest.main()
