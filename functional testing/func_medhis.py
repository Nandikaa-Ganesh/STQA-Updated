from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

def login(driver, username, password):
    driver.get('http://localhost/stqa/login.php')  # Adjust URL as needed

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

def test_update_medical_details(username, password, medical_history, allergies, current_medications, chronic_conditions, expected_message):
    driver = webdriver.Chrome()
    driver.implicitly_wait(10)  # Set implicit wait for element availability

    try:
        # Log in first
        login(driver, username, password)

        # Navigate to the update medical details page
        driver.get('http://localhost/stqa/medical_details.php')  # Adjust URL as needed

        WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.NAME, 'medical_history'))
        )

        # Fill in the form
        driver.find_element(By.NAME, 'medical_history').clear()
        driver.find_element(By.NAME, 'medical_history').send_keys(medical_history)
        driver.find_element(By.NAME, 'allergies').clear()
        driver.find_element(By.NAME, 'allergies').send_keys(allergies)
        driver.find_element(By.NAME, 'current_medications').clear()
        driver.find_element(By.NAME, 'current_medications').send_keys(current_medications)
        driver.find_element(By.NAME, 'chronic_conditions').clear()
        driver.find_element(By.NAME, 'chronic_conditions').send_keys(chronic_conditions)
        driver.find_element(By.CSS_SELECTOR, 'button[type="submit"]').click()

        # Wait for response message
        WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.TAG_NAME, 'body'))
        )

        body_text = driver.find_element(By.TAG_NAME, 'body').text
        assert expected_message in body_text, f"Expected '{expected_message}' in body text, got: {body_text}"

        print(f"Test passed for updating medical details with username '{username}'.")

    except Exception as e:
        print(f"An error occurred: {e}")
    finally:
        driver.quit()

def test_redirect_to_login():
    driver = webdriver.Chrome()
    driver.implicitly_wait(10)  # Set implicit wait for element availability

    try:
        # Navigate to the update medical details page without logging in
        driver.get('http://localhost/stqa/medical_details.php')  # Adjust URL as needed

        # Wait for redirection to login page
        WebDriverWait(driver, 10).until(
            EC.url_contains('login.php')
        )

        assert 'login.php' in driver.current_url, f"Expected redirection to 'login.php', but got: {driver.current_url}"

        print("Test passed for redirection to login page when not logged in.")

    except Exception as e:
        print(f"An error occurred: {e}")
    finally:
        driver.quit()

# Test scenarios
test_update_medical_details('shreyR', 'securePassword123', 'History', 'No Allergies', 'None', 'None', 'Medical details saved successfully!')
test_redirect_to_login()
