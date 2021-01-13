vault {
  address = "${VAULT_HTTP_ADDR}"

  ssl {
    enabled = false
    verify = false
  }
}

exec {
  command = "php-fpm"
}
