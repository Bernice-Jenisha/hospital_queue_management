// ================= LOGIN VALIDATION =================

const loginForm = document.getElementById("loginForm");

if(loginForm){

loginForm.addEventListener("submit",function(e){

    e.preventDefault();

    const email = document.getElementById("loginEmail").value;
    const password = document.getElementById("loginPassword").value;

    if(email === "patient@gmail.com" && password === "12345"){

        alert("Login Successful!");

        window.location.href = "dashboard.html";
    }
    else{
        alert("Invalid Email or Password");
    }

});

}

// ================= REGISTRATION VALIDATION =================

const registerForm = document.getElementById("registerForm");

if(registerForm){

registerForm.addEventListener("submit",function(e){

    e.preventDefault();

    const password = document.getElementById("password").value;
    const confirm = document.getElementById("confirmPassword").value;

    if(password !== confirm){
        alert("Passwords do not match.");
        return;
    }

    alert("Registration Successful! Please Login.");

    window.location.href="login.html";

});

}
// ================= APPOINTMENT PAGE =================

const departmentSelect = document.getElementById("department");
const doctorSelect = document.getElementById("doctor");

const doctors = {
    Cardiology:["Dr. Priya Sharma","Dr. Arjun Patel"],
    ENT:["Dr. Meena Krishnan","Dr. Rohit Singh"],
    Neurology:["Dr. Rahul Kumar","Dr. Sneha Joseph"],
    Orthopedics:["Dr. Anjali Menon","Dr. Vivek Raj"],
    Pediatrics:["Dr. Kavya Nair","Dr. Harish Kumar"]
};

if(departmentSelect){

    departmentSelect.addEventListener("change",function(){

        doctorSelect.innerHTML = "<option value=''>Select Doctor</option>";

        doctors[this.value].forEach(function(doc){

            let option = document.createElement("option");
            option.textContent = doc;
            option.value = doc;
            doctorSelect.appendChild(option);

        });

    });

}

const appointmentForm = document.getElementById("appointmentForm");

if(appointmentForm){

appointmentForm.addEventListener("submit",function(e){

    e.preventDefault();

    let token = "A-" + Math.floor(Math.random()*90+10);
    let wait = Math.floor(Math.random()*30+10) + " Minutes";

    document.getElementById("tokenCard").style.display="block";

    document.getElementById("tokenNumber").innerText = token;
    document.getElementById("displayDoctor").innerText = doctorSelect.value;
    document.getElementById("displayDepartment").innerText = departmentSelect.value;
    document.getElementById("displayDate").innerText = document.getElementById("appointmentDate").value;
    document.getElementById("displayTime").innerText = document.getElementById("timeSlot").value;
    document.getElementById("waitingTime").innerText = wait;

    // Save queue information for queue page
    localStorage.setItem("queueToken",token);
    localStorage.setItem("queueDoctor",doctorSelect.value);
    localStorage.setItem("queueDepartment",departmentSelect.value);
    localStorage.setItem("queueDate",document.getElementById("appointmentDate").value);
    localStorage.setItem("queueTime",document.getElementById("timeSlot").value);
    localStorage.setItem("queueWaiting",wait);

    alert("Appointment Confirmed Successfully!");

});

}
// ================= QUEUE PAGE =================

const queueToken = document.getElementById("queueToken");

if(queueToken){

    queueToken.innerText = localStorage.getItem("queueToken") || "A--";

    document.getElementById("queueDoctor").innerText = localStorage.getItem("queueDoctor") || "-";
    document.getElementById("queueDepartment").innerText = localStorage.getItem("queueDepartment") || "-";
    document.getElementById("queueDate").innerText = localStorage.getItem("queueDate") || "-";
    document.getElementById("queueTime").innerText = localStorage.getItem("queueTime") || "-";
    document.getElementById("queueWaiting").innerText = localStorage.getItem("queueWaiting") || "20 Minutes";

    let current = parseInt(
    (localStorage.getItem("currentServing") || "A-15").split("-")[1]
);
    let userToken = parseInt((localStorage.getItem("queueToken") || "A-21").split("-")[1]);

    let ahead = userToken - current;

    if(ahead < 0) ahead = 0;

    document.getElementById("patientsAhead").innerText = ahead;
    document.getElementById("currentToken").innerText = "A-" + current;

    let progress = ((current / userToken) * 100);
    if(progress > 100) progress = 100;

    document.getElementById("progressFill").style.width = progress + "%";

    document.getElementById("liveWaiting").innerText = ahead * 3 + " Minutes";

    document.getElementById("refreshQueue").addEventListener("click",function(){

        if(current < userToken){
            current++;
            ahead--;
        }

        document.getElementById("currentToken").innerText = "A-" + current;
        document.getElementById("patientsAhead").innerText = ahead;
        document.getElementById("liveWaiting").innerText = Math.max(ahead * 3,0) + " Minutes";

        progress = ((current / userToken) * 100);
        if(progress > 100) progress = 100;

        document.getElementById("progressFill").style.width = progress + "%";

        if(current === userToken){
            document.getElementById("progressText").innerText = "It's your turn! Please proceed to the consultation room.";
            alert("Your Token is Now Being Called!");
        }

    });

}
// ================= DOCTOR LOGIN =================

const doctorLoginForm = document.getElementById("doctorLoginForm");

if(doctorLoginForm){

    doctorLoginForm.addEventListener("submit",function(e){

        e.preventDefault();

        const email = document.getElementById("doctorEmail").value;
        const password = document.getElementById("doctorPassword").value;

        if(email === "doctor@gmail.com" && password === "doctor123"){
            alert("Doctor Login Successful!");
            window.location.href="doctor_dashboard.html";
        } else {
            alert("Invalid Doctor Credentials");
        }

    });

}

// ================= DOCTOR DASHBOARD =================

const callNextBtn = document.getElementById("callNextBtn");
const completeBtn = document.getElementById("completeBtn");

if(callNextBtn){

    let currentToken = 15;

    callNextBtn.addEventListener("click",function(){

        currentToken++;

        document.getElementById("doctorCurrentToken").innerText = "A-" + currentToken;
        document.getElementById("patientToken").innerText = "A-" + currentToken;
        document.getElementById("patientName").innerText = "Patient Name : Token A-" + currentToken;

        localStorage.setItem("currentServing","A-" + currentToken);

        alert("Now Calling Token A-" + currentToken);

    });

    completeBtn.addEventListener("click",function(){
        alert("Consultation Completed Successfully.");
    });

}
// ================= RECEPTIONIST LOGIN =================

const receptionistLoginForm = document.getElementById("receptionistLoginForm");

if(receptionistLoginForm){

    receptionistLoginForm.addEventListener("submit",function(e){

        e.preventDefault();

        const email = document.getElementById("receptionEmail").value;
        const password = document.getElementById("receptionPassword").value;

        if(email === "reception@gmail.com" && password === "reception123"){
            alert("Receptionist Login Successful!");
            window.location.href="receptionist_dashboard.html";
        }
        else{
            alert("Invalid Receptionist Credentials");
        }

    });

}

// ================= WALK-IN PATIENT REGISTRATION =================

const walkInForm = document.getElementById("walkInForm");

if(walkInForm){

    walkInForm.addEventListener("submit",function(e){

        e.preventDefault();

        const name = document.getElementById("walkName").value;
        const dept = document.getElementById("walkDepartment").value;

        const token = "A-" + Math.floor(Math.random()*90+20);

        document.getElementById("walkTokenCard").style.display="block";
        document.getElementById("walkToken").innerText=token;
        document.getElementById("walkPatient").innerText=name;
        document.getElementById("walkDept").innerText=dept;

        const table = document.getElementById("waitingQueueTable");

        const row = table.insertRow();

        row.innerHTML=`
            <td>${token}</td>
            <td>${name}</td>
            <td>${dept}</td>
            <td><span class="status upcoming">Waiting</span></td>
        `;

        alert("Queue Token Generated Successfully!");

        walkInForm.reset();

    });

}
// ================= ADMIN LOGIN =================

const adminLoginForm = document.getElementById("adminLoginForm");

if(adminLoginForm){

    adminLoginForm.addEventListener("submit",function(e){

        e.preventDefault();

        const email = document.getElementById("adminEmail").value;
        const password = document.getElementById("adminPassword").value;

        if(email==="admin@gmail.com" && password==="admin123"){

            alert("Administrator Login Successful!");
            window.location.href="admin_dashboard.html";

        }

        else{

            alert("Invalid Administrator Credentials");

        }

    });

}