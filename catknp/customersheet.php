<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Information Sheet</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
    }
    .header {
      background-color: #007bff;
      color: #fff;
      padding: 10px 0;
      text-align: center;
    }
    .footer {
      background-color: #007bff;
      color: #fff;
      padding: 10px 0;
      text-align: center;
      position: fixed;
      bottom: 0;
      width: 100%;
    }
    .container {
      max-width: 600px;
      margin: 80px auto 20px;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    label {
      display: block;
      margin-bottom: 5px;
    }
    input {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }
    button {
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

<div class="header">
  <h1>Customer Information Sheet</h1>
</div>

<div class="container">
  <form id="customerForm">
    <label for="firstName">First Name:</label>
    <input type="text" id="firstName" name="firstName" required>

    <label for="lastName">Last Name:</label>
    <input type="text" id="lastName" name="lastName" required>

    <label for="preferredName">Preferred Name:</label>
    <input type="text" id="preferredName" name="preferredName">

    <label for="ssn">SSN:</label>
    <input type="text" id="ssn" name="ssn" required>

    <label for="weight">Weight:</label>
    <input type="text" id="weight" name="weight">

    <label for="address">Address:</label>
    <input type="text" id="address" name="address" required>

    <label for="city">City:</label>
    <input type="text" id="city" name="city" required>

    <label for="postalCode">Postal Code:</label>
    <input type="text" id="postalCode" name="postalCode" required>

    <label for="county">County:</label>
    <input type="text" id="county" name="county" required>

    <label for="householdIncome">Household Income:</label>
    <input type="text" id="householdIncome" name="householdIncome" required>

    <label for="phoneNumber">Phone Number:</label>
    <input type="text" id="phoneNumber" name="phoneNumber" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <button type="button" onclick="generatePDF()">Generate PDF</button>
  </form>
</div>

<div class="footer">
  <h2>Bizmtandaoni</h2>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
<script>
  function generatePDF() {
    const customerData = {
      firstName: document.getElementById('firstName').value,
      lastName: document.getElementById('lastName').value,
      preferredName: document.getElementById('preferredName').value,
      ssn: document.getElementById('ssn').value,
      weight: document.getElementById('weight').value,
      address: document.getElementById('address').value,
      city: document.getElementById('city').value,
      postalCode: document.getElementById('postalCode').value,
      county: document.getElementById('county').value,
      householdIncome: document.getElementById('householdIncome').value,
      phoneNumber: document.getElementById('phoneNumber').value,
      email: document.getElementById('email').value,
    };

    const pdf = new jsPDF();
    const pageTitle = "Customer Information Sheet";
    const companyName = "Bizmtandaoni";
    const pageMargin = 10;
    const lineHeight = 20;
    let currentHeight = 20;

    Object.keys(customerData).forEach(key => {
      const value = customerData[key];
      if (value) {
        pdf.text(pageMargin, currentHeight, `${key}: ${value}`);
        currentHeight += lineHeight;
      }
    });

    // Add colorful title
    pdf.setTextColor(255, 255, 255);
    pdf.setFontSize(20);
    pdf.text(10, 20, companyName);

    pdf.setTextColor(255, 255, 255);
    pdf.setFontSize(16);
    pdf.text(pageMargin, 50, pageTitle);

    currentHeight += 80;

    pdf.save('customer_information_sheet.pdf');
  }
</script>

</body>
</html>
