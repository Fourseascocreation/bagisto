<!DOCTYPE html>
<html>
    <head>
        <title>Bagisto Installer</title>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-url" content="{{ url()->to('/') }}">

        @stack('meta')

        @bagistoVite(['src/Resources/assets/css/app.css', 'src/Resources/assets/js/app.js'], 'installer')

        {{-- <link 
            type="image/x-icon"
            href="{{ Storage::url($favicon) }}" 
            rel="shortcut icon"
            sizes="16x16"
        > --}}

        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
            rel="stylesheet"
        />

        <link
            href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap"
            rel="stylesheet"
        />

        <link 
            type="image/x-icon"
            href="{{ asset('images/logo.svg') }}" 
            rel="shortcut icon"
            sizes="16x16"
        />
        
        @stack('styles')
    </head>

    <body>
        <div
            id="app"
            class="h-full"
        >
            <div class="container">
                <div class="flex [&amp;>*]:w-[50%] justify-center items-center">
                    <v-server-requirements></v-server-requirements>
                </div>
            </div>
        </div>

        @pushOnce('scripts')
            <script type="text/x-template" id="v-server-requirements-template">
                <!-- Left Side Welcome to Installation -->
                <div class="flex flex-col justify-center">
                    <div class="grid items-end max-w-[362px] m-auto h-[100vh]">
                        <div class="grid gap-[16px]">
                            <img
                                src="{{ asset('images/bagisto-logo.svg') }}"
                                alt="Bagisto Logo"
                            >

                            <div class="grid gap-[6px]">
                                <p class="text-gray-800 text-[20px] font-bold">
                                    Welcome to Installation
                                </p>

                                <p class="text-gray-600 text-[14px]">
                                    We are happy to see you here!
                                </p>
                            </div>

                            <p class="text-gray-600 text-[14px]">
                                Bagisto installation typically involves several steps. Here\'s a general outline of the installation process for Bagisto:
                            </p>

                            <div class="grid gap-[12px]">
                                <div class="flex gap-[4px] text-[14px]"
                                    :class="[stepStates.environment == 'active' ? 'font-bold' : '', 'text-gray-600']">
                                    <span v-if="stepStates.environment === 'pending'">
                                        <span class="icon-checkbox text-[20px]"></span>
                                    </span>

                                    <span v-else-if="stepStates.environment === 'active'">
                                        <span class="icon-processing text-[20px]"></span>
                                    </span>

                                    <span
                                        v-else
                                        class="icon-tick text-[20px] text-green-500"
                                    ></span>

                                    <p>Server Requirements</p>
                                </div>

                                <div
                                    class="flex gap-[4px] text-[14px]"
                                    :class="[stepStates.envSetup == 'active' ? 'font-bold' : '', 'text-gray-600']"
                                >
                                    <span v-if="stepStates.envSetup === 'pending'">
                                        <span class="icon-checkbox text-[20px]"></span>
                                    </span>

                                    <span v-else-if="stepStates.envSetup === 'active'">
                                        <span class="icon-processing text-[20px]"></span>
                                    </span>

                                    <span
                                        v-else
                                        class="icon-tick text-[20px] text-green-500"
                                    ></span>

                                    <p>Environment Configuration</p>
                                </div>

                                <div
                                    class="flex gap-[4px] text-[14px] text-gray-600"
                                    :class="[stepStates.readyForInstallation == 'active' ? 'font-bold' : '', 'text-gray-600']"
                                >
                                    <span v-if="stepStates.readyForInstallation == 'pending'">
                                        <span class="icon-checkbox text-[20px]"></span>
                                    </span>

                                    <span v-if="stepStates.readyForInstallation == 'active'">
                                        <span class="icon-processing text-[20px]"></span>
                                    </span>

                                    <span
                                        v-if="stepStates.readyForInstallation == 'complete'"
                                        class="icon-tick text-[20px] text-green-500"
                                    ></span>

                                    <p>Ready for Installation</p>
                                </div>

                                <div
                                    class="flex gap-[4px] text-[14px] text-gray-600"
                                    :class="[stepStates.createAdmin == 'active' ? 'font-bold' : '', 'text-gray-600']"
                                >
                                    <span v-if="stepStates.createAdmin == 'pending'">
                                        <span class="icon-checkbox text-[20px]"></span>
                                    </span>

                                    <span v-if="stepStates.createAdmin == 'active'">
                                        <span class="icon-processing text-[20px]"></span>
                                    </span>

                                    <span
                                        v-if="stepStates.createAdmin == 'complete'"
                                        class="icon-tick text-[20px] text-green-500"
                                    ></span>
                                    
                                    <p>Create Administrator</p>
                                </div>

                                <div
                                    class="flex gap-[4px] text-[14px] text-gray-600"
                                    :class="[stepStates.emailConfiguration == 'active' ? 'font-bold' : '', 'text-gray-600']"
                                >
                                    <span v-if="stepStates.emailConfiguration == 'pending'">
                                        <span class="icon-checkbox text-[20px]"></span>
                                    </span>

                                    <span v-if="stepStates.emailConfiguration == 'active'">
                                        <span class="icon-processing text-[20px]"></span>
                                    </span>

                                    <span
                                        v-if="stepStates.emailConfiguration == 'complete'"
                                        class="icon-tick text-[20px] text-green-500"
                                    ></span>

                                    <p>Email Configuration</p>
                                </div>

                                <!-- Installation Completed -->
                                <div
                                    class="flex gap-[4px] text-[14px] text-gray-600"
                                    :class="[stepStates.installationCompleted == 'active' ? 'font-bold' : '', 'text-gray-600']"
                                >
                                    <span v-if="stepStates.installationCompleted == 'pending'">
                                        <span class="icon-checkbox text-[20px]"></span>
                                    </span>

                                    <span v-if="stepStates.installationCompleted == 'active'">
                                        <span class="icon-processing text-[20px]"></span>
                                    </span>

                                    <span
                                        v-if="stepStates.installationCompleted == 'complete'"
                                        class="icon-tick text-[20px] text-green-500"
                                    ></span>
                                    
                                    <p>Installation Completed</p>
                                </div>
                            </div>
                        </div>

                        <p class="place-self-end w-full text-left mb-[24px]">
                            <a
                                class="text-blue-500"
                                href="https://bagisto.com/en/"
                            >
                                Bagisto
                            </a> 
                            
                            a Community Project by

                            <a
                                class="text-blue-500"
                                href="https://webkul.com/"
                            >
                                Webkul
                            </a>
                        </p>
                    </div>
                </div>

                <!-- Right Side Components -->
                <!-- Server Requirements -->
                <div class="w-full max-w-[568px] bg-white rounded-[8px] shadow-[0px_8px_10px_0px_rgba(0,0,0,0.05)] border-[1px] border-gray-300" v-if="currentStep == 'environment'">
                    <div class="flex justify-between items-center gap-[10px] px-[16px] py-[11px] border-b-[1px] border-gray-300">
                        <p class="text-[20px] text-gray-800 font-bold">
                            Server Requirements
                        </p>
                    </div>

                    <div class="flex flex-col gap-[15px] px-[30px] py-[16px] border-b-[1px] border-gray-300 h-[486px] overflow-y-auto">
                        <div class="flex gap-[4px]">
                            <span class="{{ $phpVersion['supported'] ? 'icon-tick text-[20px] text-green-500' : '' }}"></span>

                            <p class="text-[14px] text-gray-600 font-semibold">
                                PHP <span class="font-normal">(8.1 or higher)</span>
                            </p>
                        </div>

                        @foreach ($requirements['requirements'] as $requirement)
                            @foreach ($requirement as $key => $item)
                                <div class="flex gap-[4px]">
                                    <span class="{{ $item ? 'icon-tick text-green-500' : 'icon-cross text-red-500' }} text-[20px]"></span>

                                    <p class="text-[14px] text-gray-600 font-semibold">
                                        {{ $key }}
                                    </p>
                                </div>    
                            @endforeach
                        @endforeach
                    </div>

                    @php
                        $hasRequirement = false;

                        foreach ($requirements['requirements']['php'] as $value) {
                            if (!$value) {
                                $hasRequirement = true;
                                break;
                            }
                        }
                    @endphp

                    <div class="flex px-[16px] py-[10px] justify-end items-center">
                        <div 
                            class="{{ $hasRequirement ? 'opacity-50 cursor-not-allowed' : ''}} px-[12px] py-[6px] bg-blue-600 border border-blue-700 rounded-[6px] text-gray-50 font-semibold cursor-pointer {{ $hasRequirement ?: 'hover:opacity-90' }}"
                            @click="FormSubmit"
                        >
                            Continue
                        </div>
                    </div>
                </div>

                <!-- Environment Configuration .ENV -->
                <div
                    class="w-full max-w-[568px] bg-white rounded-[8px] shadow-[0px_8px_10px_0px_rgba(0,0,0,0.05)] border-[1px] border-gray-300"
                    v-if="currentStep == 'envSetup'"
                >
                    <x-installer::form
                        v-slot="{ meta, errors, handleSubmit }"
                        as="div"
                    >
                        <form
                            @submit.prevent="handleSubmit($event, FormSubmit)"
                            enctype="multipart/form-data"
                        >
                            <div class="flex justify-between items-center gap-[10px] px-[16px] py-[11px] border-b-[1px] border-gray-300">
                                <p class="text-[20px] text-gray-800 font-bold">
                                    Environment Configuration
                                </p>
                            </div>

                            <div class="flex flex-col gap-[12px] px-[30px] py-[16px] border-b-[1px] border-gray-300 h-[484px] overflow-y-auto">
                                <!-- Application Name -->
                                <x-installer::form.control-group class="mb-[10px]">
                                    <x-installer::form.control-group.label class="required">
                                        Application Name
                                    </x-installer::form.control-group.label>

                                    <x-installer::form.control-group.control
                                        type="text"
                                        name="app_name"
                                        value="Bagisto"
                                        rules="required"
                                        label="Application Name"
                                        placeholder="Bagisto"
                                    >
                                    </x-installer::form.control-group.control>

                                    <x-installer::form.control-group.error
                                        control-name="app_name"
                                    >
                                    </x-installer::form.control-group.error>
                                </x-installer::form.control-group>

                                <!-- Application Default URL -->
                                <x-installer::form.control-group class="mb-[10px]">
                                    <x-installer::form.control-group.label class="required">
                                        Default URL
                                    </x-installer::form.control-group.label>

                                    <x-installer::form.control-group.control
                                        type="text"
                                        name="app_url"
                                        value="https://localhost"
                                        rules="required"
                                        label="Default URL"
                                        placeholder="https://localhost"
                                    >
                                    </x-installer::form.control-group.control>

                                    <x-installer::form.control-group.error
                                        control-name="app_url"
                                    >
                                    </x-installer::form.control-group.error>
                                </x-installer::form.control-group>

                                <!-- Application Default Currency -->
                                <x-installer::form.control-group class="mb-[10px]">
                                    <x-installer::form.control-group.label class="required">
                                        Default Currency
                                    </x-installer::form.control-group.label>

                                    <x-installer::form.control-group.control
                                        type="select"
                                        name="app_currency"
                                        value="USD"
                                        rules="required"
                                        label="Default Currency"
                                    >
                                        <option value="USD" selected>US Dollar</option>
                                        <option value="EUR">Euro</option>
                                    </x-installer::form.control-group.control>

                                    <x-installer::form.control-group.error
                                        control-name="app_currency"
                                    >
                                    </x-installer::form.control-group.error>
                                </x-installer::form.control-group>

                                <!-- Application Default Timezone -->
                                <x-installer::form.control-group class="mb-[10px]">
                                    <x-installer::form.control-group.label class="required">
                                        Default Timezone
                                    </x-installer::form.control-group.label>
                                    
                                    @php
                                        date_default_timezone_set('UTC');

                                        $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);

                                        $current = date_default_timezone_get();
                                    @endphp

                                    <x-installer::form.control-group.control
                                        type="select"
                                        name="app_timezone"
                                        :value="$current"
                                        rules="required"
                                        label="Default Timezone"
                                        >
                                        @foreach($tzlist as $key => $value)
                                            <option
                                                value="{{ $value }}"
                                                {{ $value === $current ? 'selected' : '' }}
                                            >
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </x-installer::form.control-group.control>

                                    <x-installer::form.control-group.error
                                        control-name="app_timezone"
                                    >
                                    </x-installer::form.control-group.error>
                                </x-installer::form.control-group>

                                <!-- Application Default Locale -->
                                <x-installer::form.control-group class="mb-[10px]">
                                    <x-installer::form.control-group.label class="required">
                                        Default Locale
                                    </x-installer::form.control-group.label>

                                    <x-installer::form.control-group.control
                                        type="select"
                                        name="app_locale"
                                        value="en"
                                        rules="required"
                                        label="Default Locale"
                                    >
                                        <option value="ar">Arabic</option>
                                        <option value="nl">Dutch</option>
                                        <option value="en" selected>English</option>
                                        <option value="fr">French</option>
                                        <option value="es">Espanol</option>
                                    </x-installer::form.control-group.control>

                                    <x-installer::form.control-group.error
                                        control-name="app_locale"
                                    >
                                    </x-installer::form.control-group.error>
                                </x-installer::form.control-group>
                            </div>
                            
                            <div class="flex px-[16px] py-[10px] justify-between items-center">
                                <div
                                    class="text-[12px] text-blue-600 font-semibold cursor-pointer"
                                    @click="back"
                                >
                                    Back
                                </div>

                                <button 
                                    type="submit"
                                    class="px-[12px] py-[6px] bg-blue-600 border border-blue-700 rounded-[6px] text-gray-50 font-semibold cursor-pointer hover:opacity-90"
                                >
                                    Continue
                                </button>
                            </div>
                            
                        </form>
                    </x-installer::form>
                </div>

                <!-- Environment Configuration Database -->
                <div
                    class="w-full max-w-[568px] bg-white rounded-[8px] shadow-[0px_8px_10px_0px_rgba(0,0,0,0.05)] border-[1px] border-gray-300"
                    v-if="currentStep == 'envDatabase'"
                >
                    <x-installer::form
                        v-slot="{ meta, errors, handleSubmit }"
                        as="div"
                    >
                        <form
                            @submit.prevent="handleSubmit($event, FormSubmit)"
                            enctype="multipart/form-data"
                        >
                            <div class="flex justify-between items-center gap-[10px] px-[16px] py-[11px] border-b-[1px] border-gray-300">
                                <p class="text-[20px] text-gray-800 font-bold">
                                    Environment Configuration
                                </p>
                            </div>
    
                            <div class="flex flex-col gap-[12px] px-[30px] py-[16px] border-b-[1px] border-gray-300 h-[484px] overflow-y-auto">
                                <!-- Database Connection-->
                                <x-installer::form.control-group class="mb-[10px]">
                                    <x-installer::form.control-group.label class="required">
                                        Database Connection
                                    </x-installer::form.control-group.label>

                                    <x-installer::form.control-group.control
                                        type="select"
                                        name="db_connection"
                                        value="mysql"
                                        rules="required"
                                        label="Database Connection"
                                        placeholder="Database Connection"
                                    >
                                        <option
                                            value="mysql"
                                            selected
                                        >
                                            Mysql
                                        </option>

                                        <option value="sqlite">SQlite</option>

                                        <option value="pgsql">pgSQL</option>

                                        <option value="sqlsrv">SQLSRV</option>
                                    </x-installer::form.control-group.control>

                                    <x-installer::form.control-group.error
                                        control-name="db_connection"
                                    >
                                    </x-installer::form.control-group.error>
                                </x-installer::form.control-group>

                                <!-- Database Hostname-->
                                <x-installer::form.control-group class="mb-[10px]">
                                    <x-installer::form.control-group.label class="required">
                                        Database Hostname
                                    </x-installer::form.control-group.label>

                                    <x-installer::form.control-group.control
                                        type="text"
                                        name="db_hostname"
                                        value="127.0.0.1"
                                        rules="required"
                                        label="Database Hostname"
                                        placeholder="Database Hostname"
                                    >
                                    </x-installer::form.control-group.control>

                                    <x-installer::form.control-group.error
                                        control-name="db_hostname"
                                    >
                                    </x-installer::form.control-group.error>
                                </x-installer::form.control-group>

                                <!-- Database Port-->
                                <x-installer::form.control-group class="mb-[10px]">
                                    <x-installer::form.control-group.label class="required">
                                        Database Port
                                    </x-installer::form.control-group.label>

                                    <x-installer::form.control-group.control
                                        type="text"
                                        name="db_port"
                                        value="3306"
                                        rules="required"
                                        label="Database Port"
                                        placeholder="Database Port"
                                    >
                                    </x-installer::form.control-group.control>

                                    <x-installer::form.control-group.error
                                        control-name="db_port"
                                    >
                                    </x-installer::form.control-group.error>
                                </x-installer::form.control-group>

                                <!-- Database name-->
                                <x-installer::form.control-group class="mb-[10px]">
                                    <x-installer::form.control-group.label class="required">
                                        Database Name
                                    </x-installer::form.control-group.label>

                                    <x-installer::form.control-group.control
                                        type="text"
                                        name="db_name"
                                        :value="old('db_name')"
                                        rules="required"
                                        label="Database Name"
                                        placeholder="Database Name"
                                    >
                                    </x-installer::form.control-group.control>

                                    <x-installer::form.control-group.error
                                        control-name="db_name"
                                    >
                                    </x-installer::form.control-group.error>
                                </x-installer::form.control-group>

                                <!-- Database Prefix-->
                                <x-installer::form.control-group class="mb-[10px]">
                                    <x-installer::form.control-group.label class="required">
                                        Database Prefix
                                    </x-installer::form.control-group.label>

                                    <x-installer::form.control-group.control
                                        type="text"
                                        name="db_prefix"
                                        :value="old('db_prefix')"
                                        label="Database Prefix"
                                        placeholder="Database Prefix"
                                    >
                                    </x-installer::form.control-group.control>

                                    <x-installer::form.control-group.error
                                        control-name="db_prefix"
                                    >
                                    </x-installer::form.control-group.error>
                                </x-installer::form.control-group>

                                <!-- Database Username-->
                                <x-installer::form.control-group class="mb-[10px]">
                                    <x-installer::form.control-group.label class="required">
                                        Database Username
                                    </x-installer::form.control-group.label>

                                    <x-installer::form.control-group.control
                                        type="text"
                                        name="db_username"
                                        :value="old('db_username')"
                                        rules="required"
                                        label="Database Username"
                                        placeholder="Database Username"
                                    >
                                    </x-installer::form.control-group.control>

                                    <x-installer::form.control-group.error
                                        control-name="db_username"
                                    >
                                    </x-installer::form.control-group.error>
                                </x-installer::form.control-group>

                                <!-- Database Password-->
                                <x-installer::form.control-group class="mb-[10px]">
                                    <x-installer::form.control-group.label class="required">
                                        Database Password
                                    </x-installer::form.control-group.label>

                                    <x-installer::form.control-group.control
                                        type="password"
                                        name="db_password"
                                        :value="old('db_password')"
                                        rules="required"
                                        label="Database Password"
                                        placeholder="Database Password"
                                    >
                                    </x-installer::form.control-group.control>

                                    <x-installer::form.control-group.error
                                        control-name="db_password"
                                    >
                                    </x-installer::form.control-group.error>
                                </x-installer::form.control-group>
                            </div>

                            <div class="flex px-[16px] py-[10px] justify-between items-center">
                                <div
                                    class="text-[12px] text-blue-600 font-semibold cursor-pointer"
                                    @click="back"
                                >
                                    Back
                                </div>
    
                                <button
                                    type="submit"
                                    class="px-[12px] py-[6px] bg-blue-600 border border-blue-700 rounded-[6px] text-gray-50 font-semibold cursor-pointer hover:opacity-90"
                                >
                                    Continue
                                </button>
                            </div>
                        </form>
                    </x-installer::form>      
                </div>

                <!-- Ready For Installation -->
                <div
                    class="w-full max-w-[568px] bg-white rounded-[8px] shadow-[0px_8px_10px_0px_rgba(0,0,0,0.05)] border-[1px] border-gray-300"
                    v-if="currentStep == 'readyForInstallation'"
                >
                    <div class="flex justify-between items-center gap-[10px] px-[16px] py-[11px] border-b-[1px] border-gray-300">
                        <p class="text-[20px] text-gray-800 font-bold">
                            Installation
                        </p>
                    </div>

                    <div class="flex flex-col gap-[15px] justify-center px-[30px] py-[16px] border-b-[1px] border-gray-300 h-[484px] overflow-y-auto">
                        <div class="flex flex-col gap-[16px]">
                            <p class="text-[18px] text-gray-800 font-semibold">
                                Bagisto for Installation
                            </p>

                            <div class="grid gap-[10px]">
                                <label class="text-[14px] text-gray-600">
                                    Click the button below to
                                </label>

                                <div class="grid gap-[12px]">
                                    <div class="flex gap-[4px] text-[14px] text-gray-600">
                                        <span class="icon-processing text-[20px]"></span>

                                        <p>Create the database table</p>
                                    </div>

                                    <div class="flex gap-[4px] text-[14px] text-gray-600">
                                        <span class="icon-processing text-[20px]"></span>

                                        <p>Populate the database tables</p>
                                    </div>

                                    <div class="flex gap-[4px] text-[14px] text-gray-600">
                                        <span class="icon-processing text-[20px]"></span>

                                        <p>Publishing the vendor files</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex px-[16px] py-[10px] justify-between items-center">
                        <div
                            class="text-[12px] text-blue-600 font-semibold cursor-pointer"
                            @click="back"
                        >
                            Back
                        </div>

                        <div
                            class="px-[12px] py-[6px] bg-blue-600 border border-blue-700 rounded-[6px] text-gray-50 font-semibold cursor-pointer hover:opacity-90"
                            @click="FormSubmit"
                        >
                            Start Installation
                        </div>
                    </div>
                </div>

                <!-- Installation Processing -->
                <div
                    class="w-full max-w-[568px] bg-white rounded-[8px] shadow-[0px_8px_10px_0px_rgba(0,0,0,0.05)] border-[1px] border-gray-300"
                    v-if="currentStep == 'installProgress'"
                >
                    <div class="flex justify-between items-center gap-[10px] px-[16px] py-[11px] border-b-[1px] border-gray-300">
                        <p class="text-[20px] text-gray-800 font-bold">
                            Installation
                        </p>
                    </div>

                    <div class="flex flex-col gap-[15px] justify-center px-[30px] py-[16px] h-[484px] overflow-y-auto">
                        <div class="flex flex-col gap-[16px]">
                            <p class="text-[18px] text-gray-800 font-bold">
                                Installing Bagisto
                            </p>
                            
                            <div class="grid gap-[10px]">
                                <svg class="animate-spin h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                    >
                                    </circle>
        
                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                    >
                                    </path>
                                </svg>

                                <p class="text-[14px] text-gray-600">
                                    Creating the database tables, this can take a few moments
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- installation Log -->
                <div
                    class="w-full max-w-[568px] bg-white rounded-[8px] shadow-[0px_8px_10px_0px_rgba(0,0,0,0.05)] border-[1px] border-gray-300"
                    v-if="currentStep == 'installationLog'"
                >
                    <div
                        class="flex flex-col gap-[15px] px-[30px] py-[16px] border-b-[1px] border-gray-300 h-[486px] overflow-y-auto" v-if="seederLog"
                    >
                        <p
                            class="h-full"
                            v-html="seederLog"
                        >
                        </p>
                    </div>

                    <div class="flex px-[16px] py-[10px] justify-end items-center">
                        <button 
                            type="submit"
                            class="px-[12px] py-[6px] bg-blue-600 border border-blue-700 rounded-[6px] text-gray-50 font-semibold cursor-pointer hover:opacity-90"
                            @click="FormSubmit"
                        >
                            Continue
                        </button>
                    </div>
                </div>

                <!-- Create Administrator -->
                <div
                    class="w-full max-w-[568px] bg-white rounded-[8px] shadow-[0px_8px_10px_0px_rgba(0,0,0,0.05)] border-[1px] border-gray-300"
                    v-if="currentStep == 'createAdmin'"
                >
                    <x-installer::form
                        v-slot="{ meta, errors, handleSubmit }"
                        as="div"
                    >
                        <form
                            @submit.prevent="handleSubmit($event, FormSubmit)"
                            enctype="multipart/form-data"
                        >
                            <div class="flex justify-between items-center gap-[10px] px-[16px] py-[11px] border-b-[1px] border-gray-300">
                                <p class="text-[20px] text-gray-800 font-bold">
                                    Create Administrator
                                </p>
                            </div>

                            <div class="flex flex-col gap-[12px] px-[30px] py-[16px] border-b-[1px] border-gray-300 h-[484px] overflow-y-auto">
                                <!-- Admin -->
                                <x-installer::form.control-group class="mb-[10px]">
                                    <x-installer::form.control-group.label class="required">
                                        Admin
                                    </x-installer::form.control-group.label>

                                    <x-installer::form.control-group.control
                                        type="text"
                                        name="admin"
                                        value="Admin"
                                        rules="required"
                                        label="Admin"
                                        placeholder="Bagisto"
                                    >
                                    </x-installer::form.control-group.control>

                                    <x-installer::form.control-group.error
                                        control-name="admin"
                                    >
                                    </x-installer::form.control-group.error>
                                </x-installer::form.control-group>

                                <!-- Email -->
                                <x-installer::form.control-group class="mb-[10px]">
                                    <x-installer::form.control-group.label class="required">
                                        Email
                                    </x-installer::form.control-group.label>

                                    <x-installer::form.control-group.control
                                        type="text"
                                        name="email"
                                        value="admin@example.com"
                                        rules="required"
                                        label="Email"
                                        placeholder="admin@example.com'"
                                    >
                                    </x-installer::form.control-group.control>

                                    <x-installer::form.control-group.error
                                        control-name="email"
                                    >
                                    </x-installer::form.control-group.error>
                                </x-installer::form.control-group>

                                <!-- Password -->
                                <x-installer::form.control-group class="mb-[10px]">
                                    <x-installer::form.control-group.label class="required">
                                        Password
                                    </x-installer::form.control-group.label>

                                    <x-installer::form.control-group.control
                                        type="password"
                                        name="password"
                                        value="admin123"
                                        rules="required"
                                        label="Password"
                                    >
                                    </x-installer::form.control-group.control>

                                    <x-installer::form.control-group.error
                                        control-name="password"
                                    >
                                    </x-installer::form.control-group.error>
                                </x-installer::form.control-group>

                                <!-- Confirm Password -->
                                <x-installer::form.control-group class="mb-[10px]">
                                    <x-installer::form.control-group.label class="required">
                                        Confirm Password
                                    </x-installer::form.control-group.label>

                                    <x-installer::form.control-group.control
                                        type="password"
                                        name="confirm_password"
                                        :value="old('confirm_password')"
                                        rules="required|confirmed:@password"
                                        label="Confirm Password"
                                    >
                                    </x-installer::form.control-group.control>

                                    <x-installer::form.control-group.error
                                        control-name="confirm_password"
                                    >
                                    </x-installer::form.control-group.error>
                                </x-installer::form.control-group>
                            </div>
                            
                            <div class="flex px-[16px] py-[10px] justify-end items-center">
                                <button 
                                    type="submit"
                                    class="px-[12px] py-[6px] bg-blue-600 border border-blue-700 rounded-[6px] text-gray-50 font-semibold cursor-pointer hover:opacity-90"
                                >
                                    Continue
                                </button>
                            </div>
                            
                        </form>
                    </x-installer::form>
                </div>

                <!-- Email Configuration Form -->
                <div
                    class="w-full max-w-[568px] bg-white rounded-[8px] shadow-[0px_8px_10px_0px_rgba(0,0,0,0.05)] border-[1px] border-gray-300"
                    v-if="currentStep == 'emailConfiguration'"
                >
                    <x-installer::form
                        v-slot="{ meta, errors, handleSubmit }"
                        as="div"
                    >
                        <form
                            @submit.prevent="handleSubmit($event, FormSubmit)"
                            enctype="multipart/form-data"
                        >
                            <div class="flex justify-between items-center gap-[10px] px-[16px] py-[11px] border-b-[1px] border-gray-300">
                                <p class="text-[20px] text-gray-800 font-bold">
                                    Email Configuration
                                </p>
                            </div>

                            <div class="flex flex-col gap-[12px] px-[30px] py-[16px] border-b-[1px] border-gray-300 h-[484px] overflow-y-auto">
                                <!-- Admin -->
                                <div class="flex gap-[6px]">
                                    <x-installer::form.control-group class="w-full mb-[10px]">
                                        <x-installer::form.control-group.label class="required">
                                            Outgoing mail server
                                        </x-installer::form.control-group.label>

                                        <x-installer::form.control-group.control
                                            type="text"
                                            name="mail_host"
                                            value="smpt.mailtrap.io"
                                            rules="required"
                                            label="Outgoing mail server"
                                            placeholder="smpt.mailtrap.io"
                                        >
                                        </x-installer::form.control-group.control>

                                        <x-installer::form.control-group.error
                                            control-name="mail_host"
                                        >
                                        </x-installer::form.control-group.error>
                                    </x-installer::form.control-group>

                                    <!-- Email -->
                                    <x-installer::form.control-group class="w-full mb-[10px]">
                                        <x-installer::form.control-group.label class="required">
                                            Server port
                                        </x-installer::form.control-group.label>

                                        <x-installer::form.control-group.control
                                            type="number"
                                            name="mail_port"
                                            value="3306"
                                            rules="required"
                                            label="Server port"
                                            placeholder="3306"
                                        >
                                        </x-installer::form.control-group.control>

                                        <x-installer::form.control-group.error
                                            control-name="mail_port"
                                        >
                                        </x-installer::form.control-group.error>
                                    </x-installer::form.control-group>
                                </div>

                                <!-- Password -->
                                <x-installer::form.control-group class="mb-[10px]">
                                    <x-installer::form.control-group.label class="required">
                                        Encryption
                                    </x-installer::form.control-group.label>

                                    <x-installer::form.control-group.control
                                        type="select"
                                        name="mail_encryption"
                                        value="tls"
                                        rules="required"
                                        label="Encryption"
                                    >
                                        <option value="tls" selected>TLS</option>
                                        <option value="ssl">SSL</option>
                                    </x-installer::form.control-group.control>

                                    <x-installer::form.control-group.error
                                        control-name="mail_encryption"
                                    >
                                    </x-installer::form.control-group.error>
                                </x-installer::form.control-group>

                                <!-- Store Email Address -->
                                <x-installer::form.control-group class="mb-[10px]">
                                    <x-installer::form.control-group.label class="required">
                                        Store Email Address
                                    </x-installer::form.control-group.label>

                                    <x-installer::form.control-group.control
                                        type="text"
                                        name="mail_from_address"
                                        :value="old('mail_from_address')"
                                        rules="required"
                                        label="Store Email Address"
                                        placeholder="store@example.com"
                                    >
                                    </x-installer::form.control-group.control>

                                    <x-installer::form.control-group.error
                                        control-name="mail_from_address"
                                    >
                                    </x-installer::form.control-group.error>
                                </x-installer::form.control-group>

                                <!-- Username -->
                                <x-installer::form.control-group class="mb-[10px]">
                                    <x-installer::form.control-group.label class="required">
                                        Username
                                    </x-installer::form.control-group.label>

                                    <x-installer::form.control-group.control
                                        type="text"
                                        name="mail_username"
                                        :value="old('mail_username')"
                                        rules="required"
                                        label="Username"
                                        placeholder="store@example.com"
                                    >
                                    </x-installer::form.control-group.control>

                                    <x-installer::form.control-group.error
                                        control-name="mail_username"
                                    >
                                    </x-installer::form.control-group.error>
                                </x-installer::form.control-group>

                                <!-- Password -->
                                <x-installer::form.control-group class="mb-[10px]">
                                    <x-installer::form.control-group.label class="required">
                                        Password
                                    </x-installer::form.control-group.label>

                                    <x-installer::form.control-group.control
                                        type="password"
                                        name="mail_password"
                                        :value="old('mail_password')"
                                        rules="required"
                                        label="Password"
                                        placeholder="store@example.com"
                                    >
                                    </x-installer::form.control-group.control>

                                    <x-installer::form.control-group.error
                                        control-name="mail_password"
                                    >
                                    </x-installer::form.control-group.error>
                                </x-installer::form.control-group>
                            </div>
                            
                            <div class="flex px-[16px] py-[10px] justify-end items-center">
                                <button 
                                    type="submit"
                                    class="px-[12px] py-[6px] bg-blue-600 border border-blue-700 rounded-[6px] text-gray-50 font-semibold cursor-pointer hover:opacity-90"
                                >
                                    Save configuration
                                </button>
                            </div>
                            
                        </form>
                    </x-installer::form>
                </div>

                <!-- Installation Completed -->
                <div
                    class="w-full max-w-[568px] bg-white rounded-[8px] shadow-[0px_8px_10px_0px_rgba(0,0,0,0.05)] border-[1px] border-gray-300"
                    v-if="currentStep == 'installationCompleted'"
                >
                    <div class="flex justify-between items-center gap-[10px] px-[16px] py-[11px] border-b-[1px] border-gray-300">
                        <p class="text-[20px] text-gray-800 font-bold">
                            Installation
                        </p>
                    </div>

                    <div class="flex flex-col gap-[15px] justify-center px-[30px] py-[16px] border-b-[1px] border-gray-300 h-[484px] overflow-y-auto">
                        <div class="flex flex-col gap-[16px]">
                            <div class="flex items-center justify-center rounded-full border border-green-500 w-[30px] h-[30px]">
                                <span class="icon-tick text-[20px] text-green-500 font-semibold"></span>
                            </div>

                            <div class="grid gap-[10px]">
                                <p class="text-[18px] text-gray-800 font-semibold">
                                    Installing Completed
                                </p>

                                <p class="text-[14px] text-gray-600">
                                    Bagisto is successfully installed on your system.
                                </p>

                                <div class="flex justify-between items-center max-w-[288px]">
                                    <a
                                        href="{{ URL('/admin/login')}}"
                                        class="px-[12px] py-[6px] bg-white border border-blue-700 rounded-[6px] text-blue-600 font-semibold cursor-pointer hover:opacity-90"
                                    >
                                        Admin Panel
                                    </a>

                                    <a
                                        href="{{ URL('/')}}"
                                        class="px-[12px] py-[6px] bg-blue-600 border border-blue-700 rounded-[6px] text-gray-50 font-semibold cursor-pointer hover:opacity-90"
                                    >
                                        Customer Panel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex px-[16px] py-[10px] justify-between items-center">
                        <a
                            href="https://forums.bagisto.com"
                            class="text-[12px] text-blue-600 font-semibold cursor-pointer"
                        >
                            Bagisto Forums
                        </a>

                        <a
                            href="https://bagisto.com/en/extensions"
                            class="px-[12px] py-[6px] bg-white border border-blue-700 rounded-[6px] text-blue-600 font-semibold cursor-pointer hover:opacity-90"
                        >
                            Explore Bagisto Extentions
                        </a>
                    </div>
                </div>
            </script>

            <script type="module">
                app.component('v-server-requirements', {
                    template: '#v-server-requirements-template',
            
                    data() {
                        return {
                            step: '',

                            currentStep: 'environment',

                            envData: {},

                            stepStates: {
                                environment: 'active',
                                envSetup: 'pending',
                                readyForInstallation: 'pending',
                                createAdmin: 'pending',
                                emailConfiguration: 'pending',
                                installationCompleted: 'pending',
                            },
                            
                            steps: [
                                'environment',
                                'envSetup',
                                'envDatabase',
                                'readyForInstallation',
                                'installProgress',
                                'installationLog',
                                'createAdmin',
                                'emailConfiguration',
                                'installationCompleted',
                            ],

                            seederLog: {},
                        }
                    },

                    methods: {
                        FormSubmit(params) {
                            let stepActions = {
                                environment: () => {
                                    this.stepStates.environment = 'complete';

                                    this.currentStep = 'envSetup';

                                    this.stepStates.envSetup = 'active';
                                },

                                envSetup: () => {
                                    this.envData = { ...params };

                                    this.currentStep = 'envDatabase';
                                },

                                envDatabase: () => {
                                    this.stepStates.envSetup = 'complete';

                                    this.envData = { ...this.envData, ...params };
                                    
                                    this.currentStep = 'readyForInstallation';

                                    this.stepStates.readyForInstallation = 'active';
                                },

                                readyForInstallation: () => {
                                    this.currentStep = 'installProgress';
                                    
                                    this.complete();
                                },
                                
                                installationLog: () => {
                                    this.stepStates.readyForInstallation = 'complete';

                                    this.currentStep = 'createAdmin';
                                    
                                    this.stepStates.createAdmin = 'active';
                                },

                                createAdmin: () => {
                                    this.stepStates.createAdmin = 'complete';

                                    this.saveAdmin(params);

                                    this.stepStates.emailConfiguration = 'active';
                                },

                                emailConfiguration: () => {
                                    this.saveSmtp(params);

                                    this.stepStates.emailConfiguration = 'complete';
                                },
                            };

                            const index = this.steps.find(step => step === this.currentStep);

                            if (stepActions[index]) {
                                stepActions[index]();
                            }
                        },

                        complete() {
                            this.$axios.post("{{ route('installer.envFileSetup') }}", this.envData)
                                .then((response) => {
                                    this.seederLog = response.data.data;

                                    this.currentStep = 'installationLog';

                                    // this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                                })
                                .catch(error => {
                                    if (error.response.status == 422) {
                                        setErrors(error.response.data.errors);
                                    }
                                });
                        },

                        saveAdmin(params) {
                            this.$axios.post("{{ route('installer.adminConfigSetup') }}", params)
                                .then((response) => {
                                    this.currentStep = 'emailConfiguration';
                                })
                                .catch(error => {
                                    setErrors(error.response.data.errors);
                                });
                        },

                        saveSmtp(params) {
                            this.$axios.post("{{ route('installer.smtpConfigSetup') }}", params)
                                .then((response) => {
                                    this.currentStep = 'installationCompleted';

                                    this.stepStates.installationCompleted == 'active';
                                })
                                .catch(error => {
                                    setErrors(error.response.data.errors);
                                });
                        },

                        back() {
                            let index = this.steps.indexOf(this.currentStep);

                            if (index >0) {
                                this.currentStep = this.steps[index -1];
                            }
                        },
                    },
                });
            </script>
        @endPushOnce

        @stack('scripts')
    </body>
</html>