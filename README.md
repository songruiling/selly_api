## selly.cc 接口使用方法


```php



use Wending\Selly\Wallet
use GuzzleHttp\Exception\ClientException;

$wallet = new Wallet()
$wallet->token('im@selly.cc', '123456')
$wallet->balance('1JpdeYddxcgXUdB2G4NDjS1irKhQzSWedn')

try {
	$wallet->withdraw('1JpdeYddxcgXUdB2G4NDjS1irKhQzSWedn', '0.001', '1JpdeYddxcgXUdB2G4NDjS1irKhQzSWedn', 'omni_usdt');
} catch (ClientException $e) {
	dump($e->getMessage());
}



```