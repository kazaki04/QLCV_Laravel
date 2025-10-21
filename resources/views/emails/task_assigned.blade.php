<p>Xin chào {{ $task->assignee->name }},</p>
<p>Bạn vừa được giao công việc sau:</p>
<ul>
    <li><strong>Tiêu đề:</strong> {{ $task->title }}</li>
    <li><strong>Mô tả:</strong> {{ $task->description ?: '-' }}</li>
    <li><strong>Hạn chót:</strong> {{ $task->deadline ? date('d/m/Y', strtotime($task->deadline)) : '-' }}</li>
</ul>
<p>Vui lòng kiểm tra chi tiết trên hệ thống.</p>
<p>Trân trọng,</p>
<p>Hệ thống QLCV</p>