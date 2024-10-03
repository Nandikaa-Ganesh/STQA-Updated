from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC


def test_registration_and_login(username, password):
    driver = webdriver.Chrome()
    try:
        # Step 1: Register the user
        driver.get('http://localhost/stqa/register.php')

        # Wait for the registration form to load
        WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.NAME, 'username'))
        )

        # Enter username and password for registration
        driver.find_element(By.NAME, 'username').send_keys(username)
        driver.find_element(By.NAME, 'password').send_keys(password)
        driver.find_element(By.CSS_SELECTOR, 'button[type="submit"]').click()

        # Wait for redirection to login page or error message after registration
        WebDriverWait(driver, 10).until(
            EC.url_contains('login.php') or EC.presence_of_element_located((By.XPATH, "//p[contains(text(), 'Registration failed')]"))
        )

        if "login.php" in driver.current_url:
            print(f"User '{username}' registered successfully.")

            # Step 2: Log in with the new user credentials
            driver.get('http://localhost/stqa/login.php')

            # Wait for the login form to load
            WebDriverWait(driver, 10).until(
                EC.presence_of_element_located((By.NAME, 'username'))
            )

            # Enter username and password for login
            driver.find_element(By.NAME, 'username').send_keys(username)
            driver.find_element(By.NAME, 'password').send_keys(password)
            driver.find_element(By.CSS_SELECTOR, 'button[type="submit"]').click()

            # Wait for redirection to the dashboard after login
            WebDriverWait(driver, 10).until(
                EC.url_contains('dashboard.php')
            )
            print(f"User '{username}' logged in successfully.")

            # Additional check: Verify user greeting or profile info on dashboard
            try:
                WebDriverWait(driver, 10).until(
                    EC.presence_of_element_located((By.XPATH, '//h1[contains(text(), "Your Appointments")]'))  # Update with actual text
                )
                print("User is on the dashboard and logged in successfully.")
            except Exception as e:
                print(f"Failed to find the expected dashboard element: {e}")

        else:
            print(f"Registration failed for user '{username}': User already exists or error occurred.")

            # Optional: Check for specific error message
            try:
                WebDriverWait(driver, 5).until(
                    EC.presence_of_element_located((By.XPATH, "//p[contains(text(), 'User already exists')]"))  # Update with actual error message
                )
                print("The error message for duplicate registration is displayed.")
            except Exception as e:
                print(f"Failed to find the expected error message: {e}")

    except Exception as e:
        print(f"An error occurred: {e}")
    finally:
        driver.quit()


# Test the registration and login functionality
test_registration_and_login('Kate', 'securePassword123')

# Attempt to register again with the same username to check for duplicate handling
test_registration_and_login('Kate', 'securePassword123')  # This should trigger the duplicate registration scenario
