@extends('layouts.page')
@section('title', env('APP_NAME') . ' : О нас')
@section('description', 'Узнайте о сообществе ' . env('APP_NAME') . ', созданное для игроков Path of Exile')

@section('content')
    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ asset('img/bg/bg.jpg') }}">
        </div>

        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h1 class="font-size-h1 decor-gold">Описание проекта</h1>
                            <p class="font-size-lg font-color-accent">
                                Место, где игроки могут найти полезную информацию, инструменты, программы и ресурсы для Path
                                of Exile
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-lg-5">
                    <div class="flex-col-8 flex-center font-center">
                        <img width="300px" src="{{ asset('img/decor/kv-logo.png') }}">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <img src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

    <section class="pad-y-98">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h2 class="font-size-h2 decor-gold">Подробное описание</h2>
                            <p class=" font-size-lg font-color-accent">CustomPoe - портал для сообщества игроков в Path of
                                Exile</p>
                        </div>

                        <div class="flex-col-8">
                            <p>Проект создан для сообщества игроков Path of Exile, чтобы они могли
                                делиться полезными данными, взаимодействовать,
                                изучать
                                возможности игры, находить информацию и расширять внутриигровые возможности
                            </p>

                            <p>
                                Для успешного развития проекта необходимы
                                поддержка и активное участие сообщества. Чем больше популярность и обратная связь, тем
                                легче,
                                интереснее и
                                проще развивать проект
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <img class="flip-y" src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ asset('img/bg/ranger.jpg') }}">
        </div>

        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h2 class="font-size-h2 decor-gold">Цели и задачи</h2>
                            <p class="font-size-lg font-color-accent">Создать полезную платформу для игроков</p>
                        </div>

                        <div class="flex-col-8">
                            <p>
                                Обеспечить как профессиональных игроков, так и новичков Path of Exile необходимыми
                                инструментами для более комфортного игрового процесса
                            </p>

                            <p>
                                Создать платформу, на которой игроки смогут взаимодействовать, обмениваться информацией и
                                активно участвовать в развитии проекта
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-lg-5">
                    <div class="flex-col-8 flex-center font-center">
                        <img width="300px" src="{{ asset('img/decor/icon-textures.png') }}">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <img src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

    <section class="pad-y-98">
        <div class="container">
            <div class="row g-4 align-items-center">

                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h2 class="font-size-h2 decor-gold">Автор и разработчик</h2>
                            <p class="font-size-lg font-color-accent">BeardedMark -
                                преданый фанат Path of Exile и программист</p>
                        </div>

                        <div class="flex-col-8">
                            <p>
                                Творческий человек, который видит в Path of Exile возможности для
                                самовыражения. Преданный фанат игры с 2015 года. Изучение программирования благодаря игре
                                позволило
                                стать профессиональным разработчиком в сфере веб приложений
                            </p>

                            <p>
                                Работа над проектом ведется на полном энтузиазме, что позволяет вкладывать душу в
                                функционал, быть
                                внимательным к деталям и стараться. В основном такое состояние достигается свободным
                                временем,
                                хорошим настроением и, зачастую, мотивацией
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-lg-5">
                    <div class="flex-col flex-center">
                        <img clas src="{{ asset('img/decor/title-border.png') }}">
                        <div
                            class="flex-row-13 pad-13 border-r-8 back-color-dark border-solid-1 border-color-other flex-ai-start">
                            <div class="flex-col-8">
                                <p class="font-color-second">
                                    "Я верю, что в этой игре каждый может найти что-то по душе: билды, гринд, крафт,
                                    фильтры, убежища и многое другое. Особенно радует, что с каждым обновлением игры,
                                    предоставляются
                                    новые возможности как для игроков, так и для разработчиков сторонних программ"
                                </p>
                                <p class="font-color-second">
                                    "Отдельное спасибо Path of Exile и ее игрокам за то, что провацировали меня на изучение
                                    программирования, в чем я нашел
                                    свое хобби и работу!"
                                </p>
                            </div>

                            <img src="https://web.poecdn.com/gen/image/WzAsMSx7ImlkIjo5OTksInNpemUiOiJhdmF0YXIifV0/db3383e9b1/Path_of_Exile_Gallery_Image.jpg"
                                alt="">
                        </div>
                        <img src="{{ asset('img/decor/title-border-bottom.png') }}">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <img class="flip-y" src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ asset('img/bg/community.jpg') }}">
        </div>

        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-8">
                        <h2 class="font-size-h2 decor-gold ">Совместное развитие</h2>
                        <p class="font-size-lg font-color-accent">
                            Если у вас есть интересные идеи или разработки, мы с радостью обсудим с вами их внедрение в
                            сервис
                        </p>
                    </div>
                </div>

                <div class="col col-12 col-lg-5">
                    <div class="flex-col-8 flex-center">
                        <img src="{{ asset('img/decor/menu-select-bg.png') }}">
                        <a class="decor-btn" href="https://discord.gg/jQ7FcHFSnE" target="_blank">Написать в сообщество</a>
                        <img class="flip-y" src="{{ asset('img/decor/menu-select-bg.png') }}">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <img src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

    <section class="pad-y-98">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col col-12">
                    <div class="flex-col-8">
                        <h2 class="font-size-h2 decor-gold">История создания</h2>
                        <p class="font-size-lg font-color-accent">CustomFilter - Приложение для управления файлом фильтра
                            предметов
                        </p>
                    </div>
                </div>

                <div class="col col-12 col-lg order-3 order-lg-2">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h3 class="font-size-h3 decor-gold">С чего все началось</h3>

                            <p>Изначально, проблема с ручным редактированием файла,
                                привела к идее автоматизировать этот процесс, после чего было создано приложение для
                                рабочего стола</p>

                            <p>Сначала реализовали возможность включения и отключения правил отображения. Затем возникла
                                необходимость в
                                выведении отдельных правил и глобальных настроек фильтра</p>
                        </div>

                        <div class="flex-col-8">
                            <h3 class="font-size-h3 decor-gold">Что было дальше</h3>

                            <p>После завершения стабильной версии для рабочего стола, возникли идеи перенести функционал и
                                технологии на уровень веб-приложения. Это позволило бы расширить аудиторию, устранить
                                множество
                                проблем и ошибок, добавить новый функционал и открыть возможности для новых идей</p>

                            <p>Поскольку веб-разработка была новой сферой, потребовалось много времени на приобретение
                                необходимых
                                знаний и навыков для получения новой профессии автором проекта</p>
                        </div>

                        <div class="flex-col-8">
                            <h3 class="font-size-h3 decor-gold">Планы на будущее</h3>

                            <p>С накопленным опытом стало ясно, что лучше создавать не узкопрофильные функции, а гибкие
                                платформы,
                                которые дадут пользователям больше возможностей и упростят обновления контента</p>

                            <p>Этот подход сделает проект более жизнеспособным, поддерживаемым и расширяемым. Он также
                                обеспечит
                                доступ с разных устройств для быстрого и удобного использования</p>
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-lg-5 order-2 order-lg-3">
                    <div class="flex-col flex-center">
                        <img src="{{ asset('img/decor/title-border.png') }}">
                        <div
                            class="flex-row-13 pad-13 border-r-8 back-color-dark border-solid-1 border-color-other flex-ai-start">
                            <img src="{{ asset('img/customfilter.png') }}" alt="">
                        </div>
                        <img src="{{ asset('img/decor/title-border-bottom.png') }}">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
