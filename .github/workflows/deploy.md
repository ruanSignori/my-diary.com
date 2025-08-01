# Self-hosted GitHub Actions Runner
Como configurar um self-hosted runner para ser utilizado com o GitHub Actions em um repositório.

### 1. Download

```bash
# Create a folder
mkdir actions-runner && cd actions-runner

# Download the latest runner package
curl -o actions-runner-linux-x64-2.327.1.tar.gz -L https://github.com/actions/runner/releases/download/v2.327.1/actions-runner-linux-x64-2.327.1.tar.gz

# Optional: Validate the hash
echo "{TOKEN}  actions-runner-linux-x64-2.327.1.tar.gz" | shasum -a 256 -c

# Extract the installer
tar xzf ./actions-runner-linux-x64-2.327.1.tar.gz
```

### 2. Configure

```bash
# Create the runner and start the configuration experience
./config.sh --url https://github.com/ruanSignori/my-diary.com --token AUS5F3RWCWA3CGPV6IF5Y7DIROPP4

# Last step, run it!
./run.sh
```
### 3. Executar runner self-hosted

```bash
# Use this YAML in your workflow file for each job
runs-on: self-hosted
```

## Configruação .yaml

Após concluído o processo de instalação do runner, necessário ajustar o arquivo `.github/workflows.deploy.yml`
