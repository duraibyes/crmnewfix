<table>
    <thead>
        <tr>
            <th>Lead No</th>
            <th>Lead Title</th>
            <th>Lead Description</th>
            <th>Lead Value</th>
            <th>Lead Currency</th>
            <th>Lead Type</th>
            <th>Lead Source</th>
            <th>Customer</th>
            <th>Mobile No</th>
            <th>Email</th>
            <th>City</th>
            <th>Assigned To</th>
            <th>Assigned By</th>
            <th>Added By</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($details) && !empty($details))
            @foreach ($details as $lead)
                <tr>
                    <td>{{ $lead->lead_no }}</td>
                    <td>{{ $lead->lead_subject }}</td>
                    <td>{{ $lead->lead_description ?? '' }}</td>
                    <td>{{ $lead->lead_value ?? '' }}</td>
                    <td>{{ $lead->lead_currency ?? '' }}</td>
                    <td>{{ $lead->leadType->type ?? '' }}</td>
                    <td>{{ $lead->leadSource->source ?? '' }}</td>
                    <td>{{ $lead->customer->first_name ?? '' }}</td>
                    <td>{{ $lead->mobile_no ?? '' }}</td>
                    <td>{{ $lead->email ?? '' }}</td>
                    <td>{{ $lead->city ?? '' }}</td>
                    <td>{{ $lead->assignedTo->name ?? '' }}</td>
                    <td>{{ $lead->assignedBy->name ?? '' }}</td>
                    <td>{{ $lead->added->name ?? '' }}</td>
                    <td>{{ $lead->status == 1 ? 'Active' : ($lead->status == 2 ? 'Done' : 'Inactive') }}</td>
                    <td> {{ $lead->created_at }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
