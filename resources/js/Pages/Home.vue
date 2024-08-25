<script setup>
import { Head } from "@inertiajs/vue3";
import QuestLayoutForPages from "@/Layouts/GuestLayoutForPages.vue";
import Tile from "@/Components/Tile.vue";
const props = defineProps([]);
</script>
<template>
    <Head title="Witaj" />
    <QuestLayoutForPages>
        <Tile>
        <div class="grid lg:grid-cols-2  items-start">
            <img
                width="960"
                height="540"
                class="lg:col-start-2 w-full object-cover overflow-clip rounded-xl"
                src="/storage/apple-3422174_1920.jpg"
                alt="Zdjęcie jabłka ze słuchawkami lekarskimi."
            />
            <div class="lg:row-start-1">
                <h1 class="text-4xl font-bold p-4 text-center">O nas</h1>
                <section class="flex flex-col gap-8 p-2 md:p-6 ">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Proin elementum tellus erat, non semper ligula mattis
                        in. Nunc condimentum lobortis urna id porttitor.
                        Phasellus pellentesque non eros eu ultrices.
                    </p>

                    <p>
                        Donec ultricies viverra aliquam. Curabitur porta sapien
                        a mi pulvinar, facilisis varius diam mollis. Vivamus
                        dictum mi in risus auctor, sit amet ornare ligula
                        lacinia. Pellentesque quis suscipit tellus. Pellentesque
                        nec urna dictum, eleifend est vitae, vehicula purus.
                        Fusce ac congue quam. Nulla sed consequat massa.
                    </p>

                    <p>
                        Morbi tincidunt, eros eget dapibus tempus, elit felis
                        lacinia enim, vitae porta libero velit eu turpis. Duis
                        non neque ut ligula accumsan tristique ac vitae odio. In
                        rutrum sapien interdum odio commodo suscipit. Mauris
                        auctor justo non dolor placerat malesuada. Donec eget
                        condimentum lectus. Vivamus cursus massa eu magna
                        gravida, et tristique ipsum malesuada. Curabitur et
                        nulla ut ligula viverra eleifend et eu neque.
                    </p>

                </section>
            </div>
        </div>
        <section class="flex flex-col gap-4 p-2 md:p-6">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
                elementum tellus erat, non semper ligula mattis in. Nunc
                condimentum lobortis urna id porttitor. Phasellus pellentesque
                non eros eu ultrices.
            </p>

            <p>
                Donec ultricies viverra aliquam. Curabitur porta sapien a mi
                pulvinar, facilisis varius diam mollis. Vivamus dictum mi in
                risus auctor, sit amet ornare ligula lacinia. Pellentesque quis
                suscipit tellus. Pellentesque nec urna dictum, eleifend est
                vitae, vehicula purus. Fusce ac congue quam. Nulla sed consequat
                massa.
            </p>

            <p>
                Morbi tincidunt, eros eget dapibus tempus, elit felis lacinia
                enim, vitae porta libero velit eu turpis. Duis non neque ut
                ligula accumsan tristique ac vitae odio. In rutrum sapien
                interdum odio commodo suscipit. Mauris auctor justo non dolor
                placerat malesuada. Donec eget condimentum lectus. Vivamus
                cursus massa eu magna gravida, et tristique ipsum malesuada.
                Curabitur et nulla ut ligula viverra eleifend et eu neque.
            </p>

            <p>
                Duis massa nunc, condimentum a eros sed, hendrerit viverra
                dolor. Nulla aliquet nunc sed lectus euismod, nec tincidunt
                sapien pulvinar. Integer ut tellus non metus congue mollis at at
                arcu. Nam vel luctus elit, vel fermentum quam. Cras ornare,
                tortor id dictum tincidunt, ipsum lectus euismod tellus, id
                efficitur turpis metus ut turpis. Fusce elementum eget sapien ut
                iaculis. Nunc tristique lectus elit, eu dictum eros bibendum
                non. Vivamus at hendrerit sapien.
            </p>
        </section>
        <section class="flex flex-col gap-4 p-2 md:p-6">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
                elementum tellus erat, non semper ligula mattis in. Nunc
                condimentum lobortis urna id porttitor. Phasellus pellentesque
                non eros eu ultrices.
            </p>

            <p>
                Donec ultricies viverra aliquam. Curabitur porta sapien a mi
                pulvinar, facilisis varius diam mollis. Vivamus dictum mi in
                risus auctor, sit amet ornare ligula lacinia. Pellentesque quis
                suscipit tellus. Pellentesque nec urna dictum, eleifend est
                vitae, vehicula purus. Fusce ac congue quam. Nulla sed consequat
                massa.
            </p>

            <p>
                Morbi tincidunt, eros eget dapibus tempus, elit felis lacinia
                enim, vitae porta libero velit eu turpis. Duis non neque ut
                ligula accumsan tristique ac vitae odio. In rutrum sapien
                interdum odio commodo suscipit. Mauris auctor justo non dolor
                placerat malesuada. Donec eget condimentum lectus. Vivamus
                cursus massa eu magna gravida, et tristique ipsum malesuada.
                Curabitur et nulla ut ligula viverra eleifend et eu neque.
            </p>

            <p>
                Duis massa nunc, condimentum a eros sed, hendrerit viverra
                dolor. Nulla aliquet nunc sed lectus euismod, nec tincidunt
                sapien pulvinar. Integer ut tellus non metus congue mollis at at
                arcu. Nam vel luctus elit, vel fermentum quam. Cras ornare,
                tortor id dictum tincidunt, ipsum lectus euismod tellus, id
                efficitur turpis metus ut turpis. Fusce elementum eget sapien ut
                iaculis. Nunc tristique lectus elit, eu dictum eros bibendum
                non. Vivamus at hendrerit sapien.
            </p>
        </section>
    </Tile>
    </QuestLayoutForPages>
</template>
