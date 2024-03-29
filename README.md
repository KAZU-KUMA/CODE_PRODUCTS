# CODE PRODUCTS
 
こちらは機械部品の在庫管理およびオンライン販売システムです。

![CODE PRODUCTS](https://user-images.githubusercontent.com/65232447/84732622-2150e300-afd7-11ea-8d8a-cec353284e66.png)

## URLとログイン情報  
[URL]  
https://kazuki-portfolio.work/login.php  

[ログイン情報]  
管理者としてログイン  
id: admin  
pass: admin  
一般ユーザーとしてログイン  
id: sampleuser  
pass: password  　

## 使用言語と開発環境
- 言語・・・HTML/CSS、JS、PHP、MySQL
- ツール・・・GitHub(バージョン管理)、 Docker(LAMP環境)
- OS・・・Mac
 
## 機能一覧
- サインアップ、ログイン、ログアウト機能
    - ユーザー名、パスワード共に'admin'でログインすると商品管理画面に遷移できる
    - 一般ユーザーでログインすると商品一覧画面に遷移できる
- 管理者機能
    - 商品管理画面では、新規商品登録、既存商品の情報変更(在庫数、ステータス)、削除ができる
    - ユーザー管理画面では登録された一般ユーザーの情報を確認できる
- 商品検索機能
    - 商品名による商品の絞り込みができる
- 商品並べ替え機能
    - 商品を価格の高い順、価格の安い順、売れ筋人気順、登録新着順で並べ替えることができる
- カート機能
    - 詳細画面よりカートに追加できる。
    - カート画面ではカート内に追加した商品を確認、数量変更や削除ができる
    - カート画面ではカート内に追加した商品の小計と合計金額がわかる
    - カート内の商品を購入できる
- お気に入り機能
    - 詳細画面よりお気に入りに追加できる
    - お気に入り画面ではお気に入り内に追加した商品を確認、削除ができる
- 購入履歴、購入明細機能
    - 購入した商品の履歴とその明細を確認できる
- お問い合わせ機能
    - お問い合わせ画面でサイト、商品についてお問い合わせできる
- セキュリティ対策
	- XSS対策
	- SQLインジェクション対策
	- CSRF対策
	- パスワードのハッシュ化
