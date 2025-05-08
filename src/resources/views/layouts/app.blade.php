<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furima App</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-utilities">
                <!-- ロゴ -->
                <a class="header__logo" href="/">
                    <img src="{{ asset('images/logo.svg') }}" alt="Furima App Logo" class="header__logo-img">
                </a>

                <!-- 検索ボックス -->
                <input type="text" class="header__search-box" placeholder="なにをお探しですか？">

                <!-- ナビゲーション -->
                <nav>
                    <ul class="header-nav">
                        @if (Auth::check())
                            <!-- ログアウト -->
                            <li class="header-nav__item">
                                <form action="/logout" method="post">
                                    @csrf
                                    <button type="submit" class="header-nav__link">ログアウト</button>
                                </form>
                            </li>
                            <!-- マイページ -->
                            <li class="header-nav__item">
                                <a href="/mypage" class="header-nav__link">マイページ</a>
                            </li>
                            <!-- 出品 -->
                            <li class="header-nav__item">
                                <a href="/sell" class="header-nav__button--special">出品</a>
                            </li>
                        @else
                            <!-- ログイン -->
                            <li class="header-nav__item">
                                <a href="/login" class="header-nav__link">ログイン</a>
                            </li>
                            <!-- マイページ -->
                            <li class="header-nav__item">
                                <a href="/mypage" class="header-nav__link">マイページ</a>
                            </li>
                            <!-- 出品 -->
                            <li class="header-nav__item">
                                <a href="/sell" class="header-nav__button--special">出品</a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>
