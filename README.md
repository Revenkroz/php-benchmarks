# PHP Benchmarks

## SplObjectStorage vs Array

Test performance and memory usage for [SplObjectStorage](https://www.php.net/manual/en/class.splobjectstorage.php) and array.

#### Usage
`php benchmarks/splobjectstorage-vs-array.php`

#### Calculated result

```
SplObjectStorage test
Time to fill: 0.0241971016
Time to check: 0.0091929436
Memory usage: 10.11 mb

Array test
Time to fill: 0.0317029953
Time to check: 0.0137040615
Memory usage: 29.41 mb
```
