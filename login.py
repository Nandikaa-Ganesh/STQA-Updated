from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC


def test_login(username, password, expected_result):
    driver = webdriver.Chrome()
    driver.implicitly_wait(10)  # Set implicit wait for element availability
    driver.get('http://localhost/stqa/login.php')  # Adjust the URL as needed

    try:
        # Wait for the login form to load
        WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.NAME, 'username'))
        )

        # Enter username and password
        driver.find_element(By.NAME, 'username').clear()
        driver.find_element(By.NAME, 'username').send_keys(username)
        driver.find_element(By.NAME, 'password').clear()
        driver.find_element(By.NAME, 'password').send_keys(password)
        driver.find_element(By.CSS_SELECTOR, 'button[type="submit"]').click()

        # Wait for redirection or error message
        WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.TAG_NAME, 'body'))
        )

        current_url = driver.current_url
        body_text = driver.find_element(By.TAG_NAME, 'body').text

        if expected_result == "success":
            # Check if the URL changed to the dashboard
            assert "dashboard.php" in current_url, f"Expected 'dashboard.php' in URL, got {current_url}"
            print(f"Test passed for login with username '{username}'.")
        else:
            # Check for the error message for invalid login attempts
            assert "Invalid username or password." in body_text, f"Expected error message not found. Body: {body_text}"
            assert "dashboard.php" not in current_url, f"URL should not contain 'dashboard.php' on failed login."
            print(f"Test passed for invalid login with username '{username}'.")

    except Exception as e:
        print(f"An error occurred: {e}")
    finally:
        driver.quit()


# Test scenarios
test_login('shreyR', 'securePassword123', 'success')  # Valid login
test_login('invalid_user', 'securePassword123', 'failure')  # Invalid username
test_login('shreyR', 'invalid_password', 'failure')  # Invalid password
test_login('', 'valid_password', 'failure')  # Empty username
test_login('valid_user', '', 'failure')  # Empty password
test_login('', '', 'failure')  # Empty username and password
