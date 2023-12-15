<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import {computed, onMounted,ref} from 'vue';
import VueApexCharts from 'vue3-apexcharts';

const weather_data =  ref([]);
const weather_dataReady = ref(false);

const success = async (position) => {
  const latitude = position.coords.latitude;
  const longitude = position.coords.longitude;
  const api = '05523e17e80c4d7b3ec006e16ad639f4';
  const weatherApi = `https://api.openweathermap.org/data/2.5/weather?lat=${latitude}&lon=${longitude}&appid=${api}`;

  try {
    const response = await fetch(weatherApi);
    const data = await response.json();
    return data; // Return the data to resolve the Promise
  } catch (error) {
    console.error('Error fetching weather data:', error);
    throw error; // Throw the error to reject the Promise
  }
};

const error = () => {
  console.log("Can't fetch your position");
};

const convertToCelsius = (val) => {
  return val - 273.15;
};

const getCurrentPositionAsync = () => {
  return new Promise((resolve, reject) => {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        success(position)
          .then((data) => resolve(data))
          .catch((error) => reject(error));
      },
      () => {
        error();
        reject("Can't fetch your position");
      }
    );
  });
};
    const chartOptions =  {
        chart: {
            id: 'vuechart-example',

        },
        title: {
            text: 'Water Level Chart Monitoring',
            align: 'left'
        },
        dataLabels: {
              enabled: true,
            },
        stroke: {
              curve: 'smooth'
            },
       colors: ['#38bdf8'],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                inverseColors: false,
                opacityFrom: 0.5,
                opacityTo: 0,
                stops: [0, 90, 100],
            },
        },
        xaxis:  {
            title: {
                text: 'Time',
            },
            type:'date',
            categories:[],
        } ,
        yaxis: {
            title: {
                text: 'Water Level',
            },
        },
    };
    const series  = [
        {
            name: 'Level',
            data: ['2','3','5','10','20','1','5']
        }
    ];
onMounted(async () => {
  try {
    const positionData = await getCurrentPositionAsync();
    console.log(positionData);
    weather_data.value = [
            {name:'locations',data: positionData.name},
            {name:'description',data: positionData.weather[0].description},
            {name:'icon',data:positionData.weather[0].icon},
            {name:'temp',data:convertToCelsius(positionData.main.temp).toFixed(2)},
            {name:'temp_min',data:convertToCelsius(positionData.main.temp_min).toFixed(2)},
            {name:'temp_max',data:convertToCelsius(positionData.main.temp_max).toFixed(2)},
            {name:'feels_like',data:convertToCelsius(positionData.main.feels_like).toFixed(2)},
            {name:'humidity',data:positionData.main.humidity},
            {name:'visibility',data:positionData.visibility},
            {name:'wind_speed',data:positionData.wind.speed},
            {name:'gust',data:positionData.wind.gust},
            {name:'deg',data:positionData.wind.deg},
            {name:'pressure',data:positionData.main.pressure},
            {name:'sea_level',data:positionData.main.sea_level},
        ];
    weather_dataReady.value = true;
  } catch (error) {
    console.error(error);
  }
});


</script>

<template>
     <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 lg:p-8 bg-white   "  >
                <div class="grid grid-cols-5">
                    <div class="col-span-3">
                        <div class="  text-2xl font-medium text-gray-900">
                            {{ weather_dataReady ? weather_data[0].data : '...' }} Philippines
                        </div>
                        <div class="mt-8">
                            <span class=" font-thin text-gray-500 ">Feels Like </span>
                        </div>
                        <div>
                            <span class="text-7xl font-medium text-gray-900">{{weather_dataReady ? weather_data[3].data : '...' }} &deg;</span>
                        </div>
                        <div class="uppercase text-gray-500">
                            {{weather_dataReady ? weather_data[1].data : '...' }}
                        </div>
                    </div>
                    <div class="col-span-2 flex justify-end">
                        <img class="w-32 h-32" :src="`images/weather-icons/${weather_dataReady ? weather_data[2].data : '...'}.png`" alt="Weather Icon">
                    </div>
                </div>
                <div class="grid grid-rows-7 grid-flow-col gap-2  ">
                    <div class="mt-6">
                        <div class="font-medium text-sm">Humidity</div>
                        <div class="text-sm text-gray-500">{{ weather_dataReady ? weather_data[7].data : '...' }}%</div>
                    </div>
                    <div class="mt-6">
                        <div class="font-medium text-sm">Visibility</div>
                        <div class="text-sm text-gray-500">{{ weather_dataReady ? weather_data[8].data : '...' }}km</div>
                    </div>
                    <div class="mt-6">
                        <div class="font-medium text-sm">Wind Speed</div>
                        <div class="text-sm text-gray-500">{{ weather_dataReady ? weather_data[9].data : '...' }}km/h</div>
                    </div>
                    <div class="mt-6">
                        <div class="font-medium text-sm">Gust</div>
                        <div class="text-sm text-gray-500">{{ weather_dataReady ? weather_data[10].data : '...' }}m/s</div>
                    </div>
                    <div class="mt-6">
                        <div class="font-medium text-sm">Deg</div>
                        <div class="text-sm text-gray-500">{{ weather_dataReady ? weather_data[11].data : '...' }} &deg </div>
                    </div>
                    <div class="mt-6">
                        <div class="font-medium text-sm">Pressure</div>
                        <div class="text-sm text-gray-500">{{ weather_dataReady ? weather_data[12].data : '...' }}mb</div>
                    </div>
                        <div class="mt-6">
                        <div class="font-medium text-sm">Sea Level</div>
                        <div class="text-sm text-gray-500">{{ weather_dataReady ? weather_data[13].data : '...' }}hPa</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4 max-w-7xl mx-auto sm:px-6 lg:px-8 ">
        <div class="bg-white overflow-hidden shadow-xl  ">
            <div class="bg-white border-l-8  border-green-600 ">
                <p>
                    <br>
                    <br>
                </p>
            </div>
        </div>
    </div>
    <div class="mt-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg ">
            <div class="bg-white border-b-4  border-green-600 ">
               <div id="chart" class="px-8 py-10">
                    <VueApexCharts type="area"   height="350" :options="chartOptions" :series="series"></VueApexCharts>
                </div>
            </div>
        </div>
    </div>


</template>
<style scoped>

</style>
