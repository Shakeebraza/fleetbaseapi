<!-- contact.blade.php -->
@if (!isset($contactsJson) || empty($contactsJson))
    @php
        header('Location: /');
        exit;
    @endphp
@endif
<html>
<head>
    <title>Contact List</title>
    <style>
        /* Basic styling for the table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Contact List</h1>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <!-- Add other headers as needed -->
            </tr>
        </thead>
        <tbody>
            @if(isset(contactsJson))
            @foreach($contactsJson['contacts'] as $contact)
                <tr>
                    <td>{{ $contact['firstName'] }} {{ $contact['lastName'] }}</td>
                    <td>{{ $contact['email'] }}</td>
                    <td>{{ $contact['phone'] }}</td>
                    <!-- Add other fields as needed -->
                </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</body>
</html>
