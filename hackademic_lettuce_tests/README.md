# Hackademic Lettuce Tests

A set of Lettuce tests to test the future implementations of Hackademic.

The main features of Hackademic are tested for creating a new CMS.

* Testing the student login.

Edit the following lines in `tests/features/zero.feature`.

```html
Scenario: Login with Student
    I fill in "username" with "Student account here"
    I fill in "pwd" with "Student password"
```
* Running the tests.

    * Install Lettuce.

        `=> [sudo] pip install lettuce`

    * Run the test.

        `=> lettuce features/`
