<template>
    <div class="wrapper">
        <div class="title">Register Form</div>
        <form @submit.prevent="submit">
            <!-- Username -->
            <div class="field">
                <input
                    type="text"
                    v-model="form.username"
                    :class="{ 'error-border': form.errors.username }"
                />
                <label>Username</label>
                <p v-if="form.errors.username" class="error">{{ form.errors.username }}</p>
            </div>

            <!-- Email -->
            <div class="field">
                <input
                    type="text"
                    v-model="form.email"
                    :class="{ 'error-border': form.errors.email }"
                />
                <label>Email Address</label>
                <p v-if="form.errors.email" class="error">{{ form.errors.email }}</p>
            </div>

            <!-- Password -->
            <div class="field">
                <input
                    type="text"
                    v-model="form.password"
                    :class="{ 'error-border': form.errors.password }"
                />
                <label>Password</label>
                <p v-if="form.errors.password" class="error">{{ form.errors.password }}</p>
            </div>

            <!-- Confirm Password -->
            <div class="field">
                <input
                    type="text"
                    v-model="form.password_confirmation"
                    :class="{ 'error-border': form.errors.password_confirmation }"
                />

                <label>Confirm Password</label>
                <p v-if="form.errors.password_confirmation" class="error">{{ form.errors.password_confirmation }}</p>
            </div>

            <div class="content">
                <div class="checkbox">
                    <input type="checkbox" id="remember-me" />
                    <label for="remember-me">Remember me</label>
                </div>
                <div class="pass-link">
                    <a href="#">Forgot password?</a>
                </div>
            </div>

            <div class="field">
                <input type="submit" value="Register" />
            </div>
        </form>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

const form = useForm({
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const isUsernameValid = (username) => {
    return /^[a-zA-Z0-9]+$/.test(username) && !/^\d+$/.test(username);
};

const isEmailValid = (email) => {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
};
const isPasswordStrong = (password) => {
    // Jāsatur vismaz viens burts un viens cipars
    return /[A-Za-z]/.test(password) && /\d/.test(password);
};


const submit = () => {
    form.clearErrors();

    // Username
    if (!form.username) {
        form.setError('username', 'Lūdzu ievadi lietotājvārdu.');
    } else if (form.username.length < 3 || form.username.length > 20) {
        form.setError('username', 'Lietotājvārdam jābūt no 3 līdz 20 simboliem.');
    } else if (!isUsernameValid(form.username)) {
        form.setError('username', 'Lietotājvārds drīkst saturēt burtus un ciparus, bet nevar būt tikai cipari.');
    }

    // Email
    if (!form.email) {
        form.setError('email', 'Lūdzu ievadi e-pasta adresi.');
    } else if (!isEmailValid(form.email)) {
        form.setError('email', 'Lūdzu ievadi derīgu e-pasta adresi.');
    }

    // Password
    if (!form.password) {
        form.setError('password', 'Lūdzu ievadi paroli.');
    } else if (form.password.length < 8) {
        form.setError('password', 'Parolei jābūt vismaz 8 simbolus garai.');
    } else if (!isPasswordStrong(form.password)) {
        form.setError('password', 'Parolei jāsatur gan burti, gan cipari.');
    }


    // Confirm Password
    if (!form.password_confirmation) {
        form.setError('password_confirmation', 'Lūdzu atkārtoti ievadi paroli.');
    } else if (form.password !== form.password_confirmation) {
        form.setError('password_confirmation', 'Paroles nesakrīt.');
    }

    // Ja nav kļūdu - sūtām
    if (Object.keys(form.errors).length === 0) {
        form.post(route('register'));
    }
};
</script>

<style>
@import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

html,
body {
    display: grid;
    height: 100%;
    width: 100%;
    place-items: center;
    background: #f2f2f2;
}

.wrapper {
    width: 380px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.1);
}

.wrapper .title {
    font-size: 35px;
    font-weight: 600;
    text-align: center;
    line-height: 100px;
    color: #fff;
    user-select: none;
    border-radius: 15px 15px 0 0;
    background: rgb(62, 88, 121);
}

.wrapper form {
    padding: 10px 30px 50px 30px;
}

.wrapper form .field {
    height: auto;
    width: 100%;
    margin-top: 20px;
    position: relative;
    display: flex;
    flex-direction: column;
}

.wrapper form .field input {
    height: 50px;
    width: 100%;
    outline: none;
    font-size: 17px;
    padding-left: 20px;
    border: 1px solid lightgrey;
    border-radius: 25px;
    transition: all 0.3s ease;
}

.wrapper form .field input:focus {
    border-color: #4158d0;
}

.wrapper form .field input.error-border {
    border-color: red !important;
}

.wrapper form .field label {
    position: absolute;
    top: 50%;
    left: 20px;
    color: #999999;
    font-weight: 400;
    font-size: 17px;
    pointer-events: none;
    transform: translateY(-50%);
    transition: all 0.3s ease;
}

form .field input:focus ~ label,
form .field input:valid ~ label {
    top: 0%;
    font-size: 16px;
    color: #4158d0;
    background: #fff;
    transform: translateY(-50%);
}

form .content {
    display: flex;
    width: 100%;
    height: 50px;
    font-size: 16px;
    align-items: center;
    justify-content: space-around;
}

form .content .checkbox {
    display: flex;
    align-items: center;
    justify-content: center;
}

form .content input {
    width: 15px;
    height: 15px;
    background: beige;
}

form .content label {
    color: #262626;
    user-select: none;
    padding-left: 5px;
}

form .content .pass-link {
    color: white;
}

form .field input[type='submit'] {
    color: #fff;
    border: none;
    padding-left: 0;
    margin-top: -10px;
    font-size: 20px;
    font-weight: 500;
    cursor: pointer;
    background: rgb(62, 88, 121);
    transition: all 0.3s ease;
}

form .field input[type='submit']:active {
    transform: scale(0.95);
}

form .signup-link {
    color: #262626;
    margin-top: 20px;
    text-align: center;
}

form .pass-link a,
form .signup-link a {
    color: #4158d0;
    text-decoration: none;
}

form .pass-link a:hover,
form .signup-link a:hover {
    text-decoration: underline;
}

.error {
    color: red;
    font-size: 14px;
    margin-top: 5px;
    padding-left: 10px;
}
</style>
