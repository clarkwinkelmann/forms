<?php /** @var \App\Models\Form[] $forms */ ?>

<p>{{ trans('summary.message', ['date' => $since->toIso8601String()]) }}</p>

<table>
    <thead>
    <tr>
        <th>{{ trans('summary.table.form') }}</th>
        <th>{{ trans('summary.table.submissions') }}</th>
        <th>{{ trans('summary.table.spam') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($forms as $form)
            <?php
            $spamCount = $form->submissions->where('is_spam')->count();
            ?>
        <tr>
            <td>
                <a href="{{ route('admin.forms.submissions.index', [$form->slug]) }}">{{ $form->title }}</a>
            </td>
            <td>
                {{ $form->submissions->count() - $spamCount }}
            </td>
            <td>
                {{ $spamCount }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
