<?php


?>


<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบบันทึกข้อมูลบุคลากร</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Sarabun', Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 800px;
        }

        .form-container h2 {
            text-align: center;
            color: #2E7D32;
            font-size: 1.8em;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid #4CAF50;
        }

        .form-group {
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .input-field {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .input-field:focus {
            border-color: #4CAF50;
            outline: none;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
        }

        .required {
            color: #f44336;
            margin-right: 5px;
        }

        .submit-btn {
            grid-column: 1 / -1;
            padding: 12px;
            font-size: 16px;
            background-color: #4CAF50;
            border: none;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
            width: 100%;
        }

        .submit-btn:hover {
            background-color: #45a049;
        }

        .error-message {
            color: #f44336;
            font-size: 14px;
            margin-top: 5px;
        }

        /* เพิ่ม responsive design */
        @media (max-width: 600px) {
            .form-group {
                grid-template-columns: 1fr;
            }

            .form-group label {
                justify-content: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>ระบบบันทึกข้อมูลบุคลากร</h2>
        <form id="personnelForm" action="save_personnel.php" method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <label><span class="required">*</span>ลำดับที่:</label>
                <input type="number" name="person_id" class="input-field" required>

                <label><span class="required">*</span>ชื่อ - สกุล:</label>
                <input type="text" name="person_name" class="input-field" maxlength="255" required>

                <label><span class="required">*</span>เพศ:</label>
                <select name="person_gender" class="input-field" required>
                    <option value="">เลือกเพศ</option>
                    <option value="male">ชาย</option>
                    <option value="female">หญิง</option>
                    <option value="other">อื่นๆ</option>
                </select>

                <label>ตำแหน่ง:</label>
                <input type="text" name="person_rank" class="input-field" maxlength="255">

                <label>ปฏิบัติการที่:</label>
                <input type="text" name="person_formwork" class="input-field" maxlength="255">

                <label>ระดับ:</label>
                <input type="text" name="person_level" class="input-field" maxlength="255">

                <label>เงินเดือน:</label>
                <input type="number" name="person_salary" class="input-field" step="0.01">

                <label>ชื่อเล่น:</label>
                <input type="text" name="person_nickname" class="input-field" maxlength="255">

                <label>วันเดือนปีเกิด:</label>
                <input type="date" name="person_born" class="input-field">

                <label>เลขที่ตำแหน่ง:</label>
                <input type="number" name="person_positionNum" class="input-field">

                <label>วันที่บรรจุ:</label>
                <input type="date" name="person_dateAccepting" class="input-field">

                <label>ประเภทการจ้าง:</label>
                <input type="text" name="person_typeHire" class="input-field" maxlength="255">

                <label>พ.ศ.ที่เกิด:</label>
                <input type="number" name="person_yearBorn" class="input-field" min="1900" max="2100">

                <label>พ.ศ.ที่บรรจุ:</label>
                <input type="number" name="person_yearAccepting" class="input-field" min="1900" max="2100">

                <label>เงินประจำตำแหน่ง:</label>
                <input type="number" name="person_positionAllowance" class="input-field" step="0.01">

                <label>เบอร์โทรศัพท์:</label>
                <input type="tel" name="person_phone" class="input-field" pattern="[0-9]{10}" title="กรุณากรอกหมายเลขโทรศัพท์ 10 หลัก">

                <label>วุฒิพิเศษทางการ:</label>
                <input type="text" name="person_specialQualification" class="input-field" maxlength="255">

                <label>กรุ๊ปเลือด:</label>
                <select name="person_blood" class="input-field">
                    <option value="">เลือกกรุ๊ปเลือด</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="AB">AB</option>
                    <option value="O">O</option>
                </select>

                <label>เลขที่บัตรราชการ:</label>
                <input type="text" name="person_cardNum" class="input-field" maxlength="13" pattern="[0-9]{13}" title="กรุณากรอกเลขบัตร 13 หลัก">

                <label>วันหมดอายุบัตรราชการ:</label>
                <input type="date" name="person_CardExpired" class="input-field">
            </div>

            <button type="submit" class="submit-btn">บันทึกข้อมูล</button>
        </form>
    </div>

    <script>
    function validateForm() {
        const form = document.getElementById('personnelForm');
        let isValid = true;

        // ตรวจสอบวันที่
        const dateFields = ['person_born', 'person_dateAccepting', 'person_CardExpired'];
        dateFields.forEach(fieldName => {
            const field = form[fieldName];
            if (field.value) {
                const date = new Date(field.value);
                if (isNaN(date.getTime())) {
                    alert(`กรุณากรอก${field.previousElementSibling.textContent.replace(':', '')}ให้ถูกต้อง`);
                    isValid = false;
                }
            }
        });

        // ตรวจสอบเบอร์โทรศัพท์
        const phone = form['person_phone'];
        if (phone.value && !/^\d{10}$/.test(phone.value)) {
            alert('กรุณากรอกเบอร์โทรศัพท์ 10 หลัก');
            isValid = false;
        }

        // ตรวจสอบเลขบัตร
        const cardNum = form['person_cardNum'];
        if (cardNum.value && !/^\d{13}$/.test(cardNum.value)) {
            alert('กรุณากรอกเลขบัตร 13 หลัก');
            isValid = false;
        }

        return isValid;
    }
    </script>
</body>
</html>
