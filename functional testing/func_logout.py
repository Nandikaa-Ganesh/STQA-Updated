from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

def test_logout():
    driver = webdriver.Chrome()
    driver.implicitly_wait(10)  # Set implicit wait for element availability

    try:
        # Step 1: Log in first (assuming user is already registered)
        driver.get('http://localhost/stqa/login.php')  # Adjust the URL as needed

        # Wait for the login form to load
        WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.NAME, 'username'))
        )

        # Enter username and password
        driver.find_element(By.NAME, 'username').send_keys('shreyR')
        driver.find_element(By.NAME, 'password').send_keys('securePassword123')
        driver.find_element(By.CSS_SELECTOR, 'button[type="submit"]').click()

        # Wait for redirection to the dashboard after login
        WebDriverWait(driver, 10).until(
            EC.url_contains('dashboard.php')
        )

        # Step 2: Log out
        driver.get('http://localhost/stqa/logout.php')  # Adjust the URL as needed

        # Wait for redirection to the login page after logout
        WebDriverWait(driver, 10).until(
            EC.url_contains('login.php')
        )

        current_url = driver.current_url
        body_text = driver.find_element(By.TAG_NAME, 'body').text

        # Verify if the user is redirected to the login page
        assert "login.php" in current_url, f"Expected 'login.php' in URL, got {current_url}"
        assert "Login" in body_text, f"Expected 'Login' in page content, got {body_text}"

        print("Test passed for logout functionality.")

    except Exception as e:
        print(f"An error occurred: {e}")
    finally:
        driver.quit()

# Execute the logout test
test_logout()
