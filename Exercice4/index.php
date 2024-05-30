<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cascading Dropdowns</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="mb-3">
            <label for="country" class="form-label">Country</label>
            <select class="form-select" id="country">
                <option value="">Select a country</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="state" class="form-label">State</label>
            <select class="form-select" id="state" disabled>
                <option value="">Select a state</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <select class="form-select" id="city" disabled>
                <option value="">Select a city</option>
            </select>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: 'PDO.php',
                method: 'GET',
                data: { action: 'getCountries' },
                success: function(data) {
                    let countrySelect = $('#country');
                    let countries = JSON.parse(data);
                    countries.forEach(country => {
                        countrySelect.append(`<option value="${country.id}">${country.name}</option>`);
                    });
                }
            });

            $('#country').on('change', function() {
                let countryId = $(this).val();
                $('#state').prop('disabled', true).html('<option value="">Select a state</option>');
                $('#city').prop('disabled', true).html('<option value="">Select a city</option>');

                if (countryId) {
                    $.ajax({
                        url: 'PDO.php',
                        method: 'GET',
                        data: { action: 'getRegions', countryId: countryId },
                        success: function(data) {
                            let stateSelect = $('#state');
                            let states = JSON.parse(data);
                            states.forEach(state => {
                                stateSelect.append(`<option value="${state.id}">${state.name}</option>`);
                            });
                            stateSelect.prop('disabled', false);
                        }
                    });
                }
            });

            $('#state').on('change', function() {
                let stateId = $(this).val();
                $('#city').prop('disabled', true).html('<option value="">Select a city</option>');

                if (stateId) {
                    $.ajax({
                        url: 'PDO.php',
                        method: 'GET',
                        data: { action: 'getVilles', stateId: stateId },
                        success: function(data) {
                            let citySelect = $('#city');
                            let cities = JSON.parse(data);
                            cities.forEach(city => {
                                citySelect.append(`<option value="${city.id}">${city.name}</option>`);
                            });
                            citySelect.prop('disabled', false);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
