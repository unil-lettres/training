# Commit Version Action

A simple GitHub Actions composite that updates a version number in a specified file and commits the change to a repository.

## Inputs

| Input | Description | Required | Default |
|-------|-------------|----------|---------|
| `file_path` | Path to the file containing the version | Yes | - |
| `version` | New version to set | Yes | - |
| `repository` | Target repository (owner/repo format) | No | Current repository |
| `branch` | Target branch | No | `development` |
| `commit_message` | Commit message (use `{version}`, `{version_key}`, and `{file_path}` placeholders) | No | `chore: update {version_key} to {version} in {file_path}` |
| `version_pattern` | Regex pattern to find version (use `{key}` placeholder) | No | `{key}:\s*\S+` |
| `version_replacement` | Replacement pattern (use `{key}` and `{version}` placeholders) | No | `{key}: {version}` |
| `version_key` | Key name to extract old version from (for YAML/properties files) | No | `app_image_tag` |

## Outputs

| Output | Description |
|--------|-------------|
| `success` | Whether the version was successfully updated |
| `old_version` | Previous version found in file |
| `new_version` | New version that was set |

## Security & Authentication

This action uses GitHub secrets for secure authentication:

- **Same repository**: Uses the built-in `GITHUB_TOKEN` automatically
- **Different repository**: Requires a Personal Access Token stored as `GITHUB_TOKEN` secret

### Setup for External Repositories

1. Create a Personal Access Token with `repo` scope
2. Add it as a repository secret named `GITHUB_TOKEN`
3. The action will automatically use this secret

## Examples

### Default usage (yml file, app_image_tag key)

```yaml
- name: Update app image tag
  uses: ./.github/actions/commit-version
  with:
    file_path: helm/values.yaml
    version: "v1.2.3"
```

This will update:
```yaml
app_image_tag: latest
```
to:
```yaml
app_image_tag: v1.2.3
```

### With different key

```yaml
- name: Update database image tag
  uses: ./.github/actions/commit-version
  with:
    file_path: helm/values.yaml
    version: "mysql-8.0"
    version_key: "db_image_tag"
```

### With custom patterns (json file)

```yaml
- name: Update package version
  uses: ./.github/actions/commit-version
  with:
    file_path: site/package.json
    version: "1.2.3"
    version_pattern: '"{key}":\s*"[^"]*"'
    version_replacement: '"{key}": "{version}"'
    version_key: "version"
```

### With custom patterns (env file)

```yaml
- name: Update app version
  uses: ./.github/actions/commit-version
  with:
    file_path: app/version.txt
    version: "2.0.0"
    version_pattern: '{key}=.*'
    version_replacement: '{key}={version}'
    version_key: "VERSION"
```

### Committing to an external repository

```yaml
- name: Update version in external repo
  uses: ./.github/actions/commit-version
  with:
    file_path: values.yaml
    version: "1.5.0"
    repository: myorg/helm-charts
    branch: development
  # Note: Requires GITHUB_TOKEN secret with repo access to myorg/helm-charts
```

## Required Permissions

### Same Repository
```yaml
permissions:
  contents: write
```

### External Repository
- Create a PAT with `repo` scope
- Add it as `PAT_TOKEN` repository secret
- The action automatically uses `secrets.PAT_TOKEN`
