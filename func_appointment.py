from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

def login(driver, username, password):
    try:
        driver.get('http://localhost/stqa/login.php')

        WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.NAME, 'username'))
        )

        driver.find_element(By.NAME, 'username').clear()
        driver.find_element(By.NAME, 'username').send_keys(username)
        driver.find_element(By.NAME, 'password').clear()
        driver.find_element(By.NAME, 'password').send_keys(password)
        driver.find_element(By.CSS_SELECTOR, 'button[type="submit"]').click()

        WebDriverWait(driver, 10).until(
            EC.url_contains('dashboard.php')
        )
    except Exception as e:
        print(f"Login failed: {e}")
        return False
    return True

def test_book_appointment(username, password, doctor_id, appointment_date, expected_result):
    driver = webdriver.Chrome()
    driver.implicitly_wait(10)

    try:
        if not login(driver, username, password):
            print(f"Test failed for booking appointment with doctor ID '{doctor_id}': Login failed.")
            return

        driver.get('http://localhost/stqa/book_appointment.php')

        WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.NAME, 'doctor_id'))
        )

        doctor_select = driver.find_element(By.NAME, 'doctor_id')
        for option in doctor_select.find_elements(By.TAG_NAME, 'option'):
            if option.get_attribute('value') == str(doctor_id):
                option.click()
                break

        driver.find_element(By.NAME, 'appointment_date').clear()
        driver.find_element(By.NAME, 'appointment_date').send_keys(appointment_date)
        driver.find_element(By.CSS_SELECTOR, 'button[type="submit"]').click()

        if expected_result == "success":
            WebDriverWait(driver, 10).until(
                EC.url_contains('dashboard.php')
            )
            if "dashboard.php" in driver.current_url:
                print(f"Test passed for booking appointment with doctor ID '{doctor_id}'.")
            else:
                print(f"Test failed for booking appointment with doctor ID '{doctor_id}': Expected to be redirected to dashboard.")
        else:
            WebDriverWait(driver, 10).until(
                EC.presence_of_element_located((By.TAG_NAME, 'body'))
            )
            if "Booking failed." in driver.page_source:
                print(f"Test passed for booking failure with doctor ID '{doctor_id}'.")
            else:
                print(f"Test failed for booking failure with doctor ID '{doctor_id}': Expected error message not found.")

    except Exception as e:
        print(f"An error occurred during booking appointment test with doctor ID '{doctor_id}': {e}")
    finally:
        driver.quit()

def test_delete_appointment(username, password, appointment_id, expected_result):
    driver = webdriver.Chrome()
    driver.implicitly_wait(10)

    try:
        if not login(driver, username, password):
            print(f"Test failed for deleting appointment with ID '{appointment_id}': Login failed.")
            return

        driver.get(f'http://localhost/stqa/delete_appointment.php?appointment_id={appointment_id}')

        WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.TAG_NAME, 'body'))
        )

        if expected_result == "success":
            if "dashboard.php" in driver.current_url:
                print(f"Test passed for deleting appointment with ID '{appointment_id}'.")
            else:
                print(f"Test failed for deleting appointment with ID '{appointment_id}': Expected to be redirected to dashboard.")
        else:
            if "Error deleting appointment" in driver.page_source:
                print(f"Test passed for deletion failure with appointment ID '{appointment_id}'.")
            else:
                print(f"Test failed for deletion failure with appointment ID '{appointment_id}': Expected error message not found.")

    except Exception as e:
        print(f"An error occurred during delete appointment test with ID '{appointment_id}': {e}")
    finally:
        driver.quit()

# Test scenarios for booking appointments
test_book_appointment('shreyR', 'securePassword123', 1, '2024-10-03T10:00', 'success')
test_book_appointment('shreyR', 'securePassword123', 99, '2024-10-03T10:00', 'failure')
test_book_appointment('shreyR', 'securePassword123', 1, '', 'failure')

# Test scenarios for deleting appointments
test_delete_appointment('shreyR', 'securePassword123', 1, 'success')
test_delete_appointment('shreyR', 'securePassword123', 99, 'failure')
