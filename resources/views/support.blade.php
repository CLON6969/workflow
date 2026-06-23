@extends('layouts.support')

@section('content')
<div class="min-h-screen flex flex-col lg:flex-row bg-gray-50">

    {{-- 🌍 Left Section --}}
    <div class="relative lg:w-2/5 w-full h-64 lg:h-auto">
        <img src="{{ asset('/public/uploads/pics/83.jpg') }}" alt="logo"
             class="absolute inset-0 w-full h-full object-cover opacity-70">

        <div class="absolute inset-0 bg-black bg-opacity-60 flex flex-col justify-center px-8 lg:px-12 text-white">
            <h1 class="text-3xl font-bold mb-2">Mongutech Platform</h1>
            <h2 class="text-lg lg:text-xl font-semibold mb-4">Talk to our Technical team</h2>
            <ul class="space-y-2 text-sm lg:text-base text-gray-100 list-disc list-inside">
                <li>Find the best Mongutech plan tailored to your business's unique needs</li>
                <li>Need customer support? support Enterprise Support</li>
                <li>Mongutech partners with industry leaders</li>
            </ul>
        </div>
    </div>

    {{-- 📩 Right Section --}}
    <div class="flex-1 bg-white flex items-center justify-center p-6 lg:p-12">
        <div class="w-full max-w-2xl space-y-5">

            {{-- ✅ Success Alert --}}
            @if(session('success'))
                <div id="successAlert" 
                     class="mb-6 flex items-center justify-between bg-green-100 border border-green-300 text-green-800 rounded-lg p-4 transition-opacity duration-700 ease-in-out">
                    <span>{{ session('success') }}</span>
                    <button onclick="fadeOut()" class="text-xl font-bold hover:text-green-600 focus:outline-none">&times;</button>
                </div>
            @endif

            <form method="POST" action="{{ route('support.submit') }}" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">First name *</label>
                        <input type="text" name="first_name" required class="mt-1 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Last name *</label>
                        <input type="text" name="last_name" required class="mt-1 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <label class="block text-sm font-medium text-gray-700">Company *</label>
                <input type="text" name="company" required class="mt-1 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">

                <label class="block text-sm font-medium text-gray-700">Job title *</label>
                <input type="text" name="job_title" required class="mt-1 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Work email *</label>
                        <input type="email" name="email" required class="mt-1 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Phone number</label>
                        <input type="tel" name="phone" class="mt-1 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <label class="block text-sm font-medium text-gray-700">Message</label>
                <textarea name="message" rows="4" placeholder="Describe your project, needs, and timeline." class="mt-1 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"></textarea>

                <label class="block text-sm font-medium text-gray-700">Country *</label>
                <select name="country" required class="mt-1 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Select</option>
                    @foreach(['Afghanistan','Albania','Algeria','Andorra','Angola','Antigua and Barbuda','Argentina','Armenia','Australia','Austria','Azerbaijan','Bahamas','Bahrain','Bangladesh','Barbados','Belarus','Belgium','Belize','Benin','Bhutan','Bolivia','Bosnia and Herzegovina','Botswana','Brazil','Brunei','Bulgaria','Burkina Faso','Burundi','Cabo Verde','Cambodia','Cameroon','Canada','Central African Republic','Chad','Chile','China','Colombia','Comoros','Congo, Democratic Republic of the','Congo, Republic of the','Costa Rica','Croatia','Cuba','Cyprus','Czech Republic','Denmark','Djibouti','Dominica','Dominican Republic','Ecuador','Egypt','El Salvador','Equatorial Guinea','Eritrea','Estonia','Eswatini','Ethiopia','Fiji','Finland','France','Gabon','Gambia','Georgia','Germany','Ghana','Greece','Grenada','Guatemala','Guinea','Guinea-Bissau','Guyana','Haiti','Honduras','Hungary','Iceland','India','Indonesia','Iran','Iraq','Ireland','Israel','Italy','Jamaica','Japan','Jordan','Kazakhstan','Kenya','Kiribati','Kuwait','Kyrgyzstan','Laos','Latvia','Lebanon','Lesotho','Liberia','Libya','Liechtenstein','Lithuania','Luxembourg','Madagascar','Malawi','Malaysia','Maldives','Mali','Malta','Marshall Islands','Mauritania','Mauritius','Mexico','Micronesia','Moldova','Monaco','Mongolia','Montenegro','Morocco','Mozambique','Myanmar','Namibia','Nauru','Nepal','Netherlands','New Zealand','Nicaragua','Niger','Nigeria','North Korea','North Macedonia','Norway','Oman','Pakistan','Palau','Palestine','Panama','Papua New Guinea','Paraguay','Peru','Philippines','Poland','Portugal','Qatar','Romania','Russia','Rwanda','Saint Kitts and Nevis','Saint Lucia','Saint Vincent and the Grenadines','Samoa','San Marino','Sao Tome and Principe','Saudi Arabia','Senegal','Serbia','Seychelles','Sierra Leone','Singapore','Slovakia','Slovenia','Solomon Islands','Somalia','South Africa','South Korea','South Sudan','Spain','Sri Lanka','Sudan','Suriname','Sweden','Switzerland','Syria','Taiwan','Tajikistan','Tanzania','Thailand','Timor-Leste','Togo','Tonga','Trinidad and Tobago','Tunisia','Turkey','Turkmenistan','Tuvalu','Uganda','Ukraine','United Arab Emirates','United Kingdom','United States','Uruguay','Uzbekistan','Vanuatu','Vatican City','Venezuela','Vietnam','Yemen','Zambia','Zimbabwe'] as $country)
                        <option value="{{ $country }}">{{ $country }}</option>
                    @endforeach
                </select>

                <div class="flex items-start space-x-2 mt-2">
                    <input type="checkbox" name="consent" value="1" class="mt-1 h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <p class="text-sm text-gray-600">Yes please, I’d like Mongutech and affiliates to use my information for personalized communications...</p>
                </div>

                <button type="submit" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-6 rounded-lg transition-all duration-200">
                    Support →
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function fadeOut() {
        const alert = document.getElementById('successAlert');
        if (!alert) return;
        alert.classList.add('opacity-0', 'transition-opacity', 'duration-700');
        setTimeout(() => alert.remove(), 700);
    }
    window.addEventListener('load', () => setTimeout(fadeOut, 5000));
</script>
@endsection
