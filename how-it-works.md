# How it works

Channel fees are examined and adjusted individually, periodically. For each channel:

* When local balance is high, set fees lower.
* When remote balance is high, set fees higher.
* When the number of transactions per minute is low, set fees lower.
* When the number of transactions per minute is high, set fees higher.

As the system adjusts, it will attempt to find "the sweet spot" between maximizing for high transactions and high fees.

You can measure "ideal" transactions per minute as the historical average (perhaps weighted for recency). Each channel will have a different measure.

When local balance is high and number of transactions per minute has been low for a long period of time and has fees set very low for a long period of time, the remote node has potentially very few useful outgoing connectivity/destinations, so the channel is "dead" and should be pruned.

When remote balance is high for a long period of time, then regardless of fees or transactions, the remote node has potentially poor fee management or very few useful incoming connectivity/sources, so the channel is "dead" and should be pruned.

If transactions per minute is below a base threshold for a long period of time, the remote node potentially has very few useful connections, so it should be pruned. The minimum base threshold is probably something like 1 transaction every 2 weeks. That comes out to 0.00004 transactions per minute. Anything less than that is likely not a useful channel.

Example:

Channel A has a 50/50 balance and current fee is 0 base 100 ppm and historical average tpm is 0.001 (one transaction per 165 hours).

At the next checkpoint, some time passes without any transactions, so the current tpm is now 0.0009 (one transaction per 185 hours).

Since tpm has gotten worse without a change in balance, we will adjust the fee by the percentage decrease in transactions. Since it was 10% worse than the historical average, we'll reduce the fee by 10% to try to attract more traffic. The new fee is set to 90 ppm.

At the next checkpoint, 1 transaction goes through. So the current tpm is now 0.0011 (one transaction per 15 hours). Now there is a change in balance, such that the local is higher and the remote is lower. This means forwarding happened and this channel was the source. Since we want to get back to 50/50, we should try to adjust the fee down. However, our tpm increased to be higher than average which would mean adjusting the fee up. We make both changes proportionally. So let's say that the imbalance wants a 10% fee down adjustment, and the throughput wants a 10% fee up adjustment. These two signals cancel each other out, and so we leave the current fee the same. 

If instead, the net adjustment was 5% up, then we would adjust the fee accordingly.

If the tpm drops over and over, which causes the fees to drop over and over, eventually it can reach the minimum fee of 1 sat. If it sits at 1 ppm for 2 weeks straight, then the channel is "dead" and pruned.

Pitfalls

Because of the nature of payments, low activity channels will not have really good tpm signals. One or two transactions can drastically change the fees causing a kind of "whiplash" adjustment effect that doesn't really suit the ideal. When things are swinging wildly this way, we don't really optimize for good fees or transactions per minute. And thus, we lose opportunities because of the swings. Because of this, it may be useful to add a "low activity dampening variable" that will reduce large swings over short periods of time. 

Effective liquidity deployment will likely drive funds to head towards more lucrative high fee and high tpm channels. While this is economically ideal, it does mean somewhat abandoning the connectivity for smaller nodes. For greater privacy and health of the network in supporting "small potato" enthusiasts, it may be good to allow some "dead" nodes. Furthermore, many people may wish to allocate liquidity for potential future use - even years into the future - for when on-chain fees may rise. So, pruning channels for being "inactive" today may be a poor punishment because it penalizes a very useful purpose of saving future fees.

Low activity during times of low on-chain fees should be somewhat expected. When on-chain fees rise, the "life" of lightning will begin to rise. On the other hand, it might be reasonable to expect "good flow" even for nodes created with the intent of reducing future transaction fees. That is, if it's a public channel, we should expect "flow" and if it's a private channel, we can let them sit without too much harm. Especially if all the liquidity of the private channel is remote. The risk is minimal to our node.

Competition in routing will generally drive fees lower and lower, especially if other nodes use a similar algorithm. This is just the nature of the beast. Opportunities will be found by exploring good, yet undiscovered nodes that will produce high flow. Or, by providing liquidity to very popular nodes that are insufficiently supported by the existing connectivity. Good monitoring of channel performance and network potential will ultimately determine the profitability of a channel or node. Selling liquidity to the highest bidder may also be a good way to be profitable.
