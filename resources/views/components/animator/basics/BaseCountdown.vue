<script lang="ts" setup>
import { ref } from "vue";

const props = withDefaults(
    defineProps<{
        color: string;
        sec: number;
        min: number;
    }>(),
    {
        color: "primary",
        sec: 0,
        min: 0,
    }
);

const seconds = ref(props.sec);
const minutes = ref(props.min);

const opacity = ref(25);
const bgColor = ref(props.color);

if (seconds.value === 0 && minutes.value === 0) {
    bgColor.value = "error";
    opacity.value = 50;
}
const interval = setInterval(() => {
    setTimeout(() => {
        if (seconds.value === 0 && minutes.value === 0) {
            clearInterval(interval);
        } else {
            if (seconds.value >= 0) {
                seconds.value--;
                if (seconds.value <= 10 && minutes.value === 0) {
                    setTimeout(() => {
                        bgColor.value = "error";
                        if (seconds.value % 2 === 0) {
                            opacity.value = 50;
                        } else {
                            opacity.value = 25;
                        }
                    }, 500);
                }
            }
            if (seconds.value < 0 && minutes.value > 0) {
                minutes.value--;
                seconds.value = 59;
            }
        }
    }, 500);
}, 1000);
</script>
<template>
    <div class="w-200 inline-block text-base">
        <p class="mb-3 text-center">Temps restant</p>
        <div class="flex auto-cols-max flex-row items-center gap-3 text-white">
            <div
                :class="`flex flex-col items-center p-4 bg-${bgColor} bg-opacity-${opacity} rounded-[20px] font-normal`">
                <span class="countdown font-medium">
                    <span :style="`--value: ${minutes}`"></span>
                </span>
                min
            </div>
            <span>:</span>
            <div
                :class="`flex flex-col items-center p-4 bg-${bgColor} bg-opacity-${opacity} rounded-[20px] font-normal`">
                <span class="countdown font-medium">
                    <span :style="`--value: ${seconds}`"></span>
                </span>
                sec
            </div>
        </div>
    </div>
</template>
