<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form @submit.prevent="submit" enctype="multipart/form-data">
        <div class="px-2 mb-1 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="grid gap-1 mb-2 md:grid-cols-2">
            <input type="file"  name="users" label="Attachment"
                class="w-full flex justify-center mr-8 px-3 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" />
            </div>
            <div class="flex items-center justify-center px-8 py-4 border-t border-gray-100">
                <PrimaryButton type="submit">Upload</PrimaryButton>
            </div>
        </div>
    </form>
</body>
</html>