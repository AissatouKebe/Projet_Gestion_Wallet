<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Wallet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <h1 class="mb-4 text-center">Gestion de Wallets</h1>

        <?php if (isset($errors['general'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($errors['general']) ?></div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5>Créer une nouvelle Wallet</h5>
            </div>
            <div class="card-body">
                <form action="/wallet/create" method="POST" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control <?= isset($errors['nom']) ? 'is-invalid' : '' ?>" 
                               value="<?= htmlspecialchars($old['nom'] ?? '') ?>">
                        <?php if (isset($errors['nom'])): ?><div class="invalid-feedback"><?= $errors['nom'] ?></div><?php endif; ?>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Prénom</label>
                        <input type="text" name="prenom" class="form-control <?= isset($errors['prenom']) ? 'is-invalid' : '' ?>" 
                               value="<?= htmlspecialchars($old['prenom'] ?? '') ?>">
                        <?php if (isset($errors['prenom'])): ?><div class="invalid-feedback"><?= $errors['prenom'] ?></div><?php endif; ?>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Téléphone</label>
                        <input type="text" name="telephone" class="form-control <?= isset($errors['telephone']) ? 'is-invalid' : '' ?>" 
                               value="<?= htmlspecialchars($old['telephone'] ?? '') ?>">
                        <?php if (isset($errors['telephone'])): ?><div class="invalid-feedback"><?= $errors['telephone'] ?></div><?php endif; ?>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Code</label>
                        <input type="text" name="code" class="form-control <?= isset($errors['code']) ? 'is-invalid' : '' ?>" 
                               value="<?= htmlspecialchars($old['code'] ?? '') ?>">
                        <?php if (isset($errors['code'])): ?><div class="invalid-feedback"><?= $errors['code'] ?></div><?php endif; ?>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">Solde</label>
                        <input type="number" step="0.01" name="solde" class="form-control <?= isset($errors['solde']) ? 'is-invalid' : '' ?>" 
                               value="<?= htmlspecialchars($old['solde'] ?? '0') ?>">
                        <?php if (isset($errors['solde'])): ?><div class="invalid-feedback"><?= $errors['solde'] ?></div><?php endif; ?>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Créer Wallet</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5>Dépôt</h5>
                    </div>
                    <div class="card-body">
                        <form action="/wallet/deposit" method="POST" class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Téléphone Wallet</label>
                                <input type="text" name="telephone_depot" class="form-control <?= isset($errors['telephone_depot']) ? 'is-invalid' : '' ?>" 
                                       value="<?= htmlspecialchars($old['telephone_depot'] ?? '') ?>">
                                <?php if (isset($errors['telephone_depot'])): ?><div class="invalid-feedback"><?= $errors['telephone_depot'] ?></div><?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Montant (CFA)</label>
                                <input type="number" step="0.01" name="montant_depot" class="form-control <?= isset($errors['montant_depot']) ? 'is-invalid' : '' ?>" 
                                       value="<?= htmlspecialchars($old['montant_depot'] ?? '') ?>">
                                <?php if (isset($errors['montant_depot'])): ?><div class="invalid-feedback"><?= $errors['montant_depot'] ?></div><?php endif; ?>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-success w-100">Effectuer Dépôt</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h5>Retrait</h5>
                    </div>
                    <div class="card-body">
                        <form action="/wallet/withdraw" method="POST" class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Téléphone Wallet</label>
                                <input type="text" name="telephone_retrait" class="form-control <?= isset($errors['telephone_retrait']) ? 'is-invalid' : '' ?>" 
                                       value="<?= htmlspecialchars($old['telephone_retrait'] ?? '') ?>">
                                <?php if (isset($errors['telephone_retrait'])): ?><div class="invalid-feedback"><?= $errors['telephone_retrait'] ?></div><?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Montant (CFA)</label>
                                <input type="number" step="0.01" name="montant_retrait" class="form-control <?= isset($errors['montant_retrait']) ? 'is-invalid' : '' ?>" 
                                       value="<?= htmlspecialchars($old['montant_retrait'] ?? '') ?>">
                                <?php if (isset($errors['montant_retrait'])): ?><div class="invalid-feedback"><?= $errors['montant_retrait'] ?></div><?php endif; ?>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-warning w-100">Effectuer Retrait (frais 1% max 5000)</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="mb-3">Wallets Existantes</h3>
        <table class="table table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom Prénom</th>
                    <th>Téléphone</th>
                    <th>Code</th>
                    <th>Solde</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($wallets ?? [] as $wallet): ?>
                <tr>
                    <td><?= $wallet->getId() ?></td>
                    <td><?= htmlspecialchars($wallet->getNom() . ' ' . $wallet->getPrenom()) ?></td>
                    <td><?= htmlspecialchars($wallet->getTelephone()) ?></td>
                    <td><?= htmlspecialchars($wallet->getCode()) ?></td>
                    <td><?= number_format($wallet->getSolde(), 2) ?> CFA</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3 class="mb-3 mt-5">Transactions Récentes</h3>
        <table class="table table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Wallet ID</th>
                    <th>Code Trans</th>
                    <th>Montant</th>
                    <th>Date</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions ?? [] as $trans): ?>
                <tr>
                    <td><?= $trans->getId() ?></td>
                    <td><?= $trans->getWalletId() ?></td>
                    <td><?= htmlspecialchars($trans->getCode()) ?></td>
                    <td><?= number_format($trans->getMontant(), 2) ?> CFA</td>
                    <td><?= \App\Config\DateUtils::formatDateString($trans->getDateHeure()) ?></td>
                    <td><span class="badge <?= $trans->getType() === 'DEPOT' ? 'bg-success' : 'bg-warning' ?>"><?= htmlspecialchars($trans->getType()) ?></span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
