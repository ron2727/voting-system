<template> 
    <h1>Candidates for election</h1>
    <div class=" mt-5 border rounded-xl overflow-hidden">
        <table class=" table-fixed w-full rounded-lg text-sm">
            <thead>
                <tr class=" border-b bg-gray-600 text-white">
                    <td class=" py-2 px-2">Candidate</td>
                    <td class=" py-2 px-2">Position</td>
                    <td class=" py-2 px-2">Votes</td>
                    <td class=" py-2 px-2">Votes percentage</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="i in 12" class=" even:bg-gray-100">
                    <td class=" py-2 px-2 text-gray-600">
                        <div class=" flex items-center space-x-1">
                            <img src="../../assets/images/user.png" alt=""
                                class=" w-10 h-10 object-cover rounded-full border">
                            <span>John Doe</span>
                        </div>
                    </td>
                    <td class=" py-2 px-2 text-gray-600">President</td>
                    <td class=" py-2 px-2 text-gray-600">0</td>
                    <td class=" py-2 px-2 text-gray-600">20%</td>
                </tr>
            </tbody>
        </table>
    </div>
</template> 