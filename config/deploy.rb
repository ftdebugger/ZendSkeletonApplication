set :application, "ZF2SkeletonApplication"
set :repository,  "HERE_NEED_TO_PASTE_REAL_REPO"
set :scm, :git

default_run_options[:pty] = true
set :deploy_to, "/home/app/root"
set :deploy_via, :remote_cache
set :branch, "production"
set :keep_releases, 3

server "ZF2SkeletonApplication", :app, :web, :db, :primary => true
set :ssh_options, {:forward_agent => true, :port => 22}
set :user, "ZF2SkeletonApplication"
set :use_sudo, false

namespace :zend do
    task :data do
        run "mkdir -p #{shared_path}/data"
        run "mkdir -p #{shared_path}/data/migrations"
        run "mkdir -p #{shared_path}/data/session"

        run "chmod -R 755 #{shared_path}/data"
        run "cp -f -R #{release_path}/data/migrations/* #{shared_path}/data/migrations/"
        run "rm -rf #{release_path}/data"
        run "ln -nfs #{shared_path}/data #{release_path}/data"
    end

    task :symlink do
    end

    task :clean do
        run "cd #{shared_path} && rm -rf data/cache/*"
    end

    task :up do
        run "cd #{release_path} && ant classmap"
        run "cd #{release_path} && ant doctrine-update"
        run "cd #{release_path} && ant assets"
    end
end

namespace :composer do
  desc "Copy vendors from previous release"
  task :copy_vendors, :except => { :no_release => true } do
    run "if [ -d #{previous_release}/vendor ]; then cp -a #{previous_release}/vendor #{latest_release}/vendor; fi"
  end
  task :install do
    run "sh -c 'cd #{release_path} && composer.phar --no-dev --optimize-autoloader install'"
  end
end

namespace :npm do
  desc "Copy vendors from previous release"
  task :copy_vendors, :except => { :no_release => true } do
    run "if [ -d #{previous_release}/node_modules ]; then cp -a #{previous_release}/node_modules #{latest_release}/node_modules; fi"
  end
  task :install do
    run "sh -c 'cd #{release_path} && npm install'"
  end
end

namespace :bower do
  task :install do
    run "sh -c 'cd #{release_path} && ant bower'"
  end
end

after "deploy:restart", "deploy:cleanup"

after "deploy:update_code", "composer:install", "npm:install", "bower:install", "zend:data", "zend:up"
after "deploy:create_symlink", "zend:symlink"

before "composer:install", "composer:copy_vendors"
before "npm:install", "npm:copy_vendors"
before "zend:up", "zend:clean"
