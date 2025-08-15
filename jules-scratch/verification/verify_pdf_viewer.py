import re
from playwright.sync_api import sync_playwright, expect

def run(playwright):
    browser = playwright.chromium.launch(headless=True)
    context = browser.new_context()
    page = context.new_page()

    # Go to login page
    page.goto("http://127.0.0.1:8000/v2/login")

    # Log in
    page.get_by_label("CI").fill("12345678")
    page.get_by_label("Contraseña").fill("password")
    page.get_by_role("button", name="Ingresar").click()

    # Wait for navigation to dashboard after login
    expect(page).to_have_url(re.compile(".*dashboard"))

    # Wait for the main content of the dashboard to be visible
    expect(page.get_by_text("¡BIENVENIDO, Administrador!")).to_be_visible()

    # Go to the PDF viewer page
    page.goto("http://127.0.0.1:8000/v2/diplomas-academicos/create")

    # The file input is hidden, so we use a locator that finds it
    # and set the file to upload.
    file_input_locator = page.locator('input[type="file"]')

    # Ensure the dropzone is visible before interacting
    dropzone_locator = page.locator('text="Arrastra tu archivo PDF aquí"')

    # Scroll the dropzone into view
    dropzone_locator.scroll_into_view_if_needed()

    expect(dropzone_locator).to_be_visible()

    # Set the input file
    file_path = "jules-scratch/verification/sample.pdf"
    file_input_locator.set_input_files(file_path)

    # Wait for the PDF to render. We can check for the canvas element.
    # The new viewer has a toolbar with "Página 1 / 1"
    page_counter_locator = page.locator('text="Página 1 / 1"')
    expect(page_counter_locator).to_be_visible(timeout=10000) # 10s timeout for rendering

    # Also check for the canvas element itself
    canvas_locator = page.locator("canvas")
    expect(canvas_locator).to_be_visible()

    # Take a screenshot of the PDF viewer component
    viewer_component_locator = page.locator('.border.rounded-lg.overflow-auto')
    expect(viewer_component_locator).to_be_visible()
    viewer_component_locator.screenshot(path="jules-scratch/verification/verification.png")

    # Clean up
    context.close()
    browser.close()

with sync_playwright() as playwright:
    run(playwright)
