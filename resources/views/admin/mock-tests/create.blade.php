@extends('layouts.admin')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-gray-800">Create New Mock Test</h1>
<form id="mockTestForm" action="{{ route('admin.mock-tests.store') }}" method="POST">
    @csrf
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="title" class="block text-gray-700 font-bold mb-2">Test Title</label>
                <input type="text" name="title" id="title" class="border rounded-md w-full p-2">
            </div>
            <div>
                <label for="subject_id" class="block text-gray-700 font-bold mb-2">Subject</label>
                <select name="subject_id" id="subject_id" class="border rounded-md w-full p-2">
                    <option value="">Select Subject</option>
                    @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="topic_id" class="block text-gray-700 font-bold mb-2">Topic</label>
                <select name="topic_id" id="topic_id" class="border rounded-md w-full p-2" disabled>
                    <option value="">Select Topic</option>
                </select>
            </div>
        </div>
    </div>

    <div id="questions-container" class="space-y-6">
        </div>

    <div class="flex justify-between items-center mt-6">
        <button type="button" id="addQuestionBtn" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded transition duration-200">Add Question</button>
        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition duration-200">Save Mock Test</button>
    </div>
</form>

<script>
    document.getElementById('subject_id').addEventListener('change', function() {
        const subjectId = this.value;
        const topicSelect = document.getElementById('topic_id');
        topicSelect.innerHTML = '<option value="">Select Topic</option>';
        topicSelect.disabled = true;

        if (subjectId) {
            fetch(`/api/topics/${subjectId}`)
                .then(response => response.json())
                .then(topics => {
                    topics.forEach(topic => {
                        topicSelect.innerHTML += `<option value="${topic.id}">${topic.name}</option>`;
                    });
                    topicSelect.disabled = false;
                });
        }
    });

    document.getElementById('addQuestionBtn').addEventListener('click', function() {
        const container = document.getElementById('questions-container');
        const questionCount = container.children.length;
        const newQuestion = document.createElement('div');
        newQuestion.className = 'bg-white p-6 rounded-lg shadow-md question-item';
        newQuestion.innerHTML = `
            <h3 class="text-lg font-semibold mb-4">Question ${questionCount + 1}</h3>
            <div class="mb-4">
                <label class="block text-gray-700">Question Text</label>
                <textarea name="questions[${questionCount}][question_text]" class="border rounded-md w-full p-2" rows="3" required></textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700">Option A</label>
                    <input type="text" name="questions[${questionCount}][options][A]" class="border rounded-md w-full p-2" required>
                </div>
                <div>
                    <label class="block text-gray-700">Option B</label>
                    <input type="text" name="questions[${questionCount}][options][B]" class="border rounded-md w-full p-2" required>
                </div>
                <div>
                    <label class="block text-gray-700">Option C</label>
                    <input type="text" name="questions[${questionCount}][options][C]" class="border rounded-md w-full p-2" required>
                </div>
                <div>
                    <label class="block text-gray-700">Option D</label>
                    <input type="text" name="questions[${questionCount}][options][D]" class="border rounded-md w-full p-2" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Correct Answer</label>
                <select name="questions[${questionCount}][correct_answer]" class="border rounded-md w-full p-2" required>
                    <option value="">Select Correct Option</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
            </div>
        `;
        container.appendChild(newQuestion);
    });
</script>
@endsection