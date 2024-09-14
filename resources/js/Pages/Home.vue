<script setup>
import { Head, Link } from "@inertiajs/vue3";
import QuestLayoutForPages from "@/Layouts/GuestLayoutForPages.vue";
import Tile from "@/Components/Tile.vue";
const props = defineProps([]);
</script>
<template>
    <Head title="Witaj" />
    <QuestLayoutForPages>
        <Tile>
            <h1 class="text-4xl font-bold text-black/80 p-8 sm:ms-12">O nas</h1>
        </Tile>

        <Tile>
            <section class="text-black/80">
                <div class="max-w-7xl overflow-clip m-2 md:m-12">
                    <img
                        width="960"
                        height="540"
                        class="block w-full object-cover overflow-clip rounded-xl"
                        src="/storage/apple-3422174_1920.jpg"
                        alt="Zdjęcie jabłka ze słuchawkami lekarskimi."
                    />
                </div>
                <p style="margin-bottom: 10pt; text-align: justify">
                    Poniżej możesz zapoznać się z krótką charakterystyką
                    portalu. Jeżeli chcesz dowiedzieć się więcej na temat
                    funkcjonalności z perspektywy pacjenta lub dietetyka,
                    wybierz jedną z poniższych zakładek:
                </p>
                <Link class="underline text-blue-500 block m-4" :href="route('about.client')">
             
                        Dla pacjenta
                   
                </Link>
                <Link class="underline text-blue-500 block m-4"  :href="route('about.dietician')">
                  
                        Dla dietetyka
                   
                </Link>
                <p style="margin-bottom: 10pt; text-align: justify">
                    <strong>&#xa0;</strong>
                </p>
                <p style="text-align: center">
                    <strong
                        >Łączymy osoby poszukujące porady żywieniowej</strong
                    >
                </p>
                <p style="text-align: center">
                    <strong
                        >z dopasowanymi i zweryfikowanymi dietetykami</strong
                    >
                </p>
                <p style="margin-bottom: 10pt; text-align: justify">
                    <strong>&#xa0;</strong>
                </p>
                <p style="margin-bottom: 10pt; text-align: justify">
                    Poznaj Dietetyka.pl to pasja do dietetyki oraz chęć rozwoju
                    dietetyki w Polsce poprzez zapewnienie pacjentom dostępności
                    do konsultacji oferowanych przez zweryfikowanych (szczegóły
                    poniżej) specjalistów, zaś dietetykom możliwości
                    zaprezentowania się na przyjaznej platformie.
                </p>
                <p style="margin-bottom: 10pt; text-align: justify">
                    <strong>&#xa0;</strong>
                </p>
                <p
                    style="
                        margin-bottom: 10pt;
                        text-align: justify;
                        line-height: 115%;
                    "
                >
                    <strong>Cele</strong>
                </p>
                <ul style="margin: 0pt; padding-left: 0pt">
                    <li
                        class="ListParagraph"
                        style="
                            text-align: justify;

                            font-family: serif;
                        "
                    >
                        <strong
                            ><span style="font-family: Arial"
                                >Dbanie o zdrowie z pomocą zweryfikowanych
                                specjalistów</span
                            ></strong
                        >
                    </li>
                    <li
                        class="ListParagraph"
                        style="
                            text-align: justify;

                            font-family: serif;
                        "
                    >
                        <strong
                            ><span style="font-family: Arial"
                                >Wspieranie dietetyków w rozwoju</span
                            ></strong
                        >
                    </li>
                    <li
                        class="ListParagraph"
                        style="
                            margin-bottom: 10pt;
                            text-align: justify;

                            font-family: serif;
                        "
                    >
                        <strong
                            ><span style="font-family: Arial"
                                >Tworzenie społeczności</span
                            ></strong
                        >
                    </li>
                </ul>
                <p style="margin-bottom: 10pt; text-align: justify">
                    Głównymi celami Poznaj Dietetyka są:
                </p>
                <ol style="margin: 0pt; padding-left: 0pt">
                    <li class="ListParagraph" style="text-align: justify">
                        Tworzenie przestrzeni, w której możesz zadbać o swoje
                        zdrowie poprzez odnalezienie odpowiedniego dla siebie
                        dietetyka o zweryfikowanym wykształceniu. Na naszym
                        portalu znajdziesz dietetyków wyłącznie po studiach.
                    </li>
                </ol>
                <p class="ListParagraph" style="text-align: justify">&#xa0;</p>
                <ol start="2" style="margin: 0pt; padding-left: 0pt">
                    <li
                        class="ListParagraph"
                        style="text-align: justify; padding-left: 3.83pt"
                    >
                        Prezentowanie dietetyków w wyselekcjonowanym gronie
                        rzetelnych specjalistów na przyjaznych warunkach oraz
                        wspieranie dietetyków, którzy dopiero rozpoczęli swoją
                        działalność i szukają sposobów na dotarcie do szerszego
                        grona pacjentów (sprawdź „Dla dietetyka”).
                    </li>
                </ol>
                <p class="ListParagraph">&#xa0;</p>
                <ol start="3" style="margin: 0pt; padding-left: 0pt">
                    <li
                        class="ListParagraph"
                        style="margin-bottom: 10pt; text-align: justify"
                    >
                        Tworzenia nie tylko „tablicy ogłoszeniowej”, lecz
                        społeczności łączącej dietetyków i pacjentów poprzez
                        wprowadzanie elementów tematycznych, skierowanych do obu
                        grup naszych użytkowników.
                    </li>
                </ol>
                <p style="margin-bottom: 10pt; text-align: justify">
                    <strong>&#xa0;</strong>
                </p>
                <p style="margin-bottom: 10pt; text-align: justify">
                    <strong>&#xa0;</strong>
                </p>
                <p style="margin-bottom: 10pt; text-align: justify">
                    <strong>&#xa0;</strong>
                </p>
                <p style="margin-bottom: 10pt; text-align: justify">
                    <strong>&#xa0;</strong>
                </p>
                <p
                    style="
                        margin-bottom: 10pt;
                        text-align: justify;
                        line-height: 115%;
                        font-size: 14pt;
                    "
                >
                    <strong>Weryfikacja dietetyków</strong
                    ><strong><span style="color: #4a86e8"> </span></strong>
                </p>
                <ul style="margin: 0pt; padding-left: 0pt">
                    <li
                        class="ListParagraph"
                        style="
                            margin-bottom: 10pt;
                            text-align: justify;

                            font-family: serif;
                        "
                    >
                        <strong
                            ><span style="font-family: Arial"
                                >Weryfikacja każdego dietetyka</span
                            ></strong
                        >
                    </li>
                </ul>
                <p style="margin-bottom: 10pt; text-align: justify">
                    Dietetyk, jak każdy specjalista odpowiedzialny za zdrowie
                    pacjentów, powinien posiadać odpowiednie kompetencje. Z tego
                    powodu, zawsze dokonujemy weryfikacji posiadanego
                    wykształcenia przez każdego dietetyka, przed umieszczeniem
                    jego profilu na naszym portalu.
                </p>
                <p style="margin-bottom: 10pt; text-align: justify">
                    <span style="color: #4a86e8">&#xa0;</span>
                </p>
                <p
                    style="
                        margin-bottom: 10pt;
                        text-align: justify;
                        line-height: 115%;
                        font-size: 13pt;
                    "
                >
                    <span
                        style="
                            width: 35.4pt;
                            line-height: 115%;
                            font-size: 11pt;
                            display: inline-block;
                        "
                        >&#xa0;</span
                    ><strong>Funkcjonalność</strong>
                </p>
                <ul style="margin: 0pt; padding-left: 0pt">
                    <li
                        class="ListParagraph"
                        style="
                            text-align: justify;
                            padding-left: 7.94pt;
                            font-family: serif;
                        "
                    >
                        <strong
                            ><span style="font-family: Arial"
                                >Szybko znajdziesz odpowiedniego
                                specjalistę</span
                            ></strong
                        >
                    </li>
                    <li
                        class="ListParagraph"
                        style="
                            margin-bottom: 10pt;
                            text-align: justify;

                            font-family: serif;
                        "
                    >
                        <strong
                            ><span style="font-family: Arial"
                                >Umówisz się na konsultację w prosty
                                sposób</span
                            ></strong
                        >
                    </li>
                </ul>
                <p style="margin-bottom: 10pt; text-align: justify">
                    Poznaj Dietetyka umożliwia szybkie odnalezienie dopasowanego
                    do siebie specjalisty i umówienie się na konsultację przy
                    użyciu kalendarza.
                </p>
                <p>
                    <span style="width: 35.4pt; display: inline-block"
                        >&#xa0;</span
                    >Więcej informacji na ten temat znajdziesz w zakładce „Dla
                    pacjenta”.
                </p>
                <p>&#xa0;</p>
                <p
                    style="
                        margin-bottom: 10pt;
                        text-indent: 36pt;
                        text-align: justify;
                        line-height: 115%;
                        font-size: 14pt;
                    "
                >
                    <strong>Rozwój</strong>
                </p>
                <ul style="margin: 0pt; padding-left: 0pt">
                    <li
                        class="ListParagraph"
                        style="
                            text-align: justify;

                            font-family: serif;
                        "
                    >
                        <strong
                            ><span style="font-family: Arial"
                                >Edukujemy w zakresie żywienia</span
                            ></strong
                        >
                    </li>
                    <li
                        class="ListParagraph"
                        style="
                            margin-bottom: 10pt;
                            text-align: justify;

                            font-family: serif;
                        "
                    >
                        <strong
                            ><span style="font-family: Arial"
                                >Zwiększamy dostępność wiedzy</span
                            ></strong
                        >
                    </li>
                </ul>
                <p style="text-align: justify">
                    Poznaj Dietetyka to platforma, poprzez którą tworzymy
                    społeczność opartą na przyjaznych relacjach i warunkach.
                    Zwiększamy dostęp do edukacji żywieniowej wśród osób
                    zawodowo niezwiązanych z żywieniem. Wprowadzamy kolejne
                    udogodnienia zwiększające możliwości funkcjonalne naszego
                    portalu. Zależy nam już teraz na stałym kontakcie z Wami,
                    dlatego aktywnie prowadzimy profile społecznościowe na
                    Instagramie, Facebooku, TikToku i YouTube’ie.
                </p>
            </section>
        </Tile>
    </QuestLayoutForPages>
</template>
<style scoped>
p {
    margin: 0pt;
}
li {
    margin-top: 0pt;
    margin-bottom: 0pt;
}
.ListParagraph {
    margin-bottom: 0pt;
    line-height: 115%;
    font-family: Arial;
    font-size: 11pt;
}
@media (max-width: 900px) {
    img {
        max-width: 100%;
        height: auto;
    }

    .table-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    td,
    th {
        padding: 8px;

        text-align: left;
        border: 1px solid #ddd;
    }
}
</style>
