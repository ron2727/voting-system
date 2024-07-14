<template>
    <div class=" border rounded-3xl">
        <div class="m-5">
            <div class=" py-3 px-4 bg-white rounded-xl w-min">
                <slot name="icon"></slot>
            </div>
            <h6 class=" mt-4 font-semibold text-sm text-gray-200 ">
                <slot name="label"></slot>
            </h6>
            <h6 class=" mt-1 font-bold text-3xl text-white ">
                <slot name="value"></slot>
            </h6>
        </div>
    </div>
</template>
 