# ============================================================
# AI Enterprise CRM —— SuiteCRM 应用容器
# 基础镜像：PHP 8.3 + Apache（与生产环境保持一致）
# ============================================================
FROM php:8.3-apache

LABEL maintainer="AI Enterprise CRM" \
      description="SuiteCRM 7.15 based enterprise CRM for AI solution sales teams"

# ---------- 安装系统依赖与 PHP 扩展 ----------
RUN apt-get update && apt-get install -y --no-install-recommends \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libzip-dev \
        libicu-dev \
        libldap2-dev \
        libcurl4-openssl-dev \
        libonig-dev \
        libxml2-dev \
        zip \
        unzip \
        curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu \
    && docker-php-ext-install -j"$(nproc)" \
        mysqli \
        pdo_mysql \
        gd \
        zip \
        intl \
        mbstring \
        curl \
        ldap \
        soap \
        xml \
        bcmath \
        exif \
    && a2enmod rewrite headers expires \
    && rm -rf /var/lib/apt/lists/*

# ---------- PHP 运行参数 ----------
COPY deploy/docker/php.ini /usr/local/etc/php/conf.d/zz-aiecrm.ini

# ---------- Apache 站点配置 ----------
COPY deploy/docker/apache-vhost.conf /etc/apache2/sites-available/000-default.conf

# ---------- 应用源码 ----------
# 本仓库定位为「二次开发作品仓库」，不含 SuiteCRM 上游源码，
# 因此镜像构建分三步合成一个完整应用：
#   ① 下载 SuiteCRM 官方发布包并解压为基底
#   ② 叠加本项目的二次开发覆盖层（crm/custom、crm/modules、config_override.php）
#   ③ 叠加部署期资源（兼容补丁、中文语言包）
WORKDIR /var/www/html

ARG SUITECRM_VERSION=7.15.2
ARG SUITECRM_SHA256=9d66c7f6e14f4f1dc4c4605185be6fb97ad1902c0026ff326a7c20e9a4901180

# ① 上游基底
RUN set -eux; \
    curl -fsSL -o /tmp/suitecrm.zip \
        "https://github.com/SuiteCRM/SuiteCRM/releases/download/v${SUITECRM_VERSION}/SuiteCRM-${SUITECRM_VERSION}.zip"; \
    echo "${SUITECRM_SHA256}  /tmp/suitecrm.zip" | sha256sum -c -; \
    unzip -q /tmp/suitecrm.zip -d /tmp/scrm; \
    cp -a "/tmp/scrm/SuiteCRM-${SUITECRM_VERSION}/." /var/www/html/; \
    rm -rf /tmp/suitecrm.zip /tmp/scrm

# ② 二次开发覆盖层（路径与 SuiteCRM 应用根目录一致，直接叠加）
COPY crm/ /var/www/html/

# ③ 部署期兼容补丁：补齐 SuiteCRM 7.15.x 缺失的 modules/UpgradeWizard/uw_utils.php
#    （该文件被上游移除但安装脚本仍无条件引用，会导致静默安装中断）
COPY deploy/patches/modules/ /var/www/html/modules/

# ③ 中文语言包（按 SuiteCRM 相对路径镜像存放）
COPY deploy/i18n/zh_CN/ /var/www/html/

# ---------- 启动脚本（首次启动自动完成静默安装）----------
COPY deploy/docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["apache2-foreground"]
